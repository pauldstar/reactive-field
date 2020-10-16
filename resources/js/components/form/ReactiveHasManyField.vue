<template>
    <section class="mb-8">
        <tabs
            v-if="field.showTableGroups"
            :id="fieldName"
            :editable="true"
            :sortable="true"
            @select-tab="selectedGroupIndex = $event"
            @add-tab="createGroup"
            @update-tab="updateGroup"
            @sort-tab="sortGroups"
            @delete-tab="deleteGroup"
        >
            <tab
                v-for="(group, index) in tableGroups"
                :key="index"
                :name="group.name"
                :sortable="group.draggable"
                :editable="group.draggable"
                :selected="!index"
            >
                <resource-index
                    :field="field"
                    :draggable="field.draggable && group.draggable"
                    :resource-id="resourceId"
                    :resource-name="field.resourceName"
                    :via-resource="resourceName"
                    :via-resource-id="resourceId"
                    :via-relationship="field.hasManyRelationship"
                    :table-group-id="group.id"
                    :relationship-type="'hasMany'"
                    :load-cards="false"
                    @sort-note="sortNotes"
                    @sort-resource="sortResources"
                />
            </tab>
        </tabs>

        <resource-index
            v-else
            :field="field"
            :resource-id="resourceId"
            :resource-name="field.resourceName"
            :via-resource="resourceName"
            :via-resource-id="resourceId"
            :via-relationship="field.hasManyRelationship"
            :relationship-type="'hasMany'"
            :load-cards="false"
            @sort-note="sortNotes"
            @sort-resource="sortResources"
        />

        <portal to="modals" transition="fade-transition">
            <create-relation-modal
                v-if="relationModalOpen"
                :field-name="fieldName"
                :table-group-id="selectedGroup && selectedGroup.id"
                @cancelled-create="closeRelationModal"
                :resource-id="modalResourceId"
                :resource-name="modalResourceName"
                :via-relationship="modalViaRelationship"
                :via-resource="modalViaResource"
                :via-resource-id="modalViaResourceId"
            />
        </portal>
    </section>
</template>

<script>
function valueToString() {
    let id, arr = '';

    this.forEach(obj => {
        id = typeof obj.id === 'object' ? obj.id.value : obj.id;
        arr += `${id}-`;
    });

    return arr;
}

import ReactiveField from "../../mixins/ReactiveField";
import AddResource from "@ui/mixins/ResourceCrud";
import FormFieldStatus from "@ui/mixins/FormFieldStatus";
import Tabs from "@ui/components/tabs/Tabs";
import Tab from "@ui/components/tabs/Tab";
import {FormField} from 'laravel-nova';

export default {
    mixins: [ReactiveField, FormField, FormFieldStatus, AddResource],

    props: [
        'mode',
        'panel',
        'field',
        'resourceId',
        'resourceName',
    ],

    components: {Tab, Tabs},

    async created() {
        if (['custom-detail', 'custom-edit'].includes(this.$route.name)) {
            this.disableFieldStatus();
        } else this.triggerFormChange = true;

        await this.getTableGroups();
        if (this.resourceId === 0) await this.forceDeleteUnsavedChanges();
    },

    mounted() {
        Nova.$on(this.actions, this.openRelationModal);
        Nova.$on(this.crud, this.broadcastUpdate);
        this.value.toString = valueToString;
    },

    destroyed() {
        Nova.$off(this.actions, this.openRelationModal);
        Nova.$off(this.crud, this.broadcastUpdate);
    },

    watch: {
        fieldValueLength() {
            this.value = this.field.value;
            this.value.toString = valueToString;
        }
    },

    data: _ => ({
        relationModalOpen: false,
        modalResourceId: null,
        modalResourceName: null,
        modalViaRelationship: null,
        modalViaResource: null,
        modalViaResourceId: null,
        tableGroups: [],
        selectedGroupIndex: 0
    }),

    computed: {
        selectedGroup() {
            return this.tableGroups.length
                && this.tableGroups[this.selectedGroupIndex];
        },

        fieldName() {
            return this.field ? this.field.name : '';
        },

        fieldValueLength() {
            return this.field && this.field.value.length;
        },

        actions() {
            return [
                'create-resource',
                'edit-resource'
            ].map(e => `${this.field.name}:${e}`);
        },

        crud() {
            return [
                'resource-created',
                'resource-updated',
                'resource-deleted'
            ].map(e => `${this.field.name}:${e}`);
        }
    },

    methods: {
        async forceDeleteUnsavedChanges() {
            let urlPrefix = '/fifteen-group/nova-compact-reactive-ui';

            return Nova.request({
                url: `${urlPrefix}/${this.field.resourceName}/unsaved`,
                method: 'delete',
                params: {
                    belongsTo: this.field.belongsToRelationship
                },
            }).then(_ => this.broadcast(true));
        },

        broadcastUpdate(resources) {
            this.closeRelationModal();
            this.broadcast(true);
        },

        openRelationModal(resourceName, resourceId) {
            this.modalResourceName = resourceName;
            this.modalResourceId = resourceId;

            if (resourceName === 'table-notes') {
                this.modalViaRelationship = this.field.resourceName;
                this.modalViaResource = '';
                this.modalViaResourceId = '';
            } else {
                this.modalViaRelationship = this.field.hasManyRelationship;
                this.modalViaResource = this.resourceName;
                this.modalViaResourceId = this.resourceId;
            }

            this.relationModalOpen = true
        },

        closeRelationModal() {
            this.relationModalOpen = false;
        },

        async getTableGroups() {
            return Nova.request().get('/fifteen-group/nova-compact-reactive-ui/table-groups', {
                params: {viaResource: this.field.resourceName}
            }).then(({data}) => {
                data.resources.forEach(group => {
                    let groupValues = {};

                    groupValues.id = group.id.value;
                    groupValues.draggable = this.field.draggable;
                    group.fields.forEach(field => groupValues[field.attribute] = field.value)

                    this.tableGroups.push(groupValues);
                });

                this.tableGroups.push({
                    name: 'All',
                    draggable: false,
                    position: 1 + this.tableGroups.length,
                    type: this.field.resourceName
                });
            })
        },

        async createGroup() {
            let newGroup = {
                name: `New-${this.tableGroups.length}`,
                type: this.field.resourceName,
                position: this.tableGroups.length,
                draggable: this.field.draggable
            };

            newGroup.id = await this.addResource('table-groups', newGroup);
            newGroup.id && this.tableGroups.splice(-1, 0, newGroup);
        },

        sortGroups(e) {
            let group = this.tableGroups[e.first];
            group.position = e.end + 1;
            this.amendResource('table-groups', group.id, group);
        },

        sortNotes(e) {
            let note = {position: e.end + 1};
            this.amendResource('table-notes', e.noteId, note);
        },

        sortResources(e) {
            let resource = {
                position: e.end + 1,
                tableNote: e.noteId || ''
            };

            this.amendResource(e.resourceName, e.resourceId, resource);
        },

        async updateGroup(index, newName) {
            let group = this.tableGroups[index],
                currentName = group.name;

            // change to new name here to trigger an undo if update fails
            group.name = newName;

            if (!await this.amendResource('table-groups', group.id, group))
                group.name = currentName;
        },

        deleteGroup(index) {
            if (this.removeResource('table-groups', this.tableGroups[index].id))
                this.tableGroups.splice(index, 1);
        }
    }
}
</script>
