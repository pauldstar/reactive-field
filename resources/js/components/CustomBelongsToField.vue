<template>
  <default-field :field="field" :errors="errors">
    <template slot="field">
      <div class="flex items-center">
        <search-input
          v-if="isSearchable && !isLocked && !isReadonly"
          :data-testid="`${field.resourceName}-search-input`"
          @input="performSearch"
          @clear="clearSelection"
          @selected="selectResource"
          :error="hasError"
          :value="selectedResource"
          :data="availableResources"
          :clearable="field.nullable"
          trackBy="value"
          searchBy="display"
          class="w-full"
        >
          <div slot="default" v-if="selectedResource" class="flex items-center">
            <div v-if="selectedResource.avatar" class="mr-3">
              <img
                :src="selectedResource.avatar"
                class="w-8 h-8 rounded-full block"
              />
            </div>

            {{ selectedResource.display }}
          </div>

          <div
            slot="option"
            slot-scope="{ option, selected }"
            class="flex items-center"
          >
            <div v-if="option.avatar" class="mr-3">
              <img :src="option.avatar" class="w-8 h-8 rounded-full block" />
            </div>

            {{ option.display }}
          </div>
        </search-input>

        <select-control
          v-if="!isSearchable || isLocked || isReadonly"
          class="form-control form-select w-full"
          :class="{ 'border-danger': hasError }"
          :data-testid="`${field.resourceName}-select`"
          :dusk="field.attribute"
          @change="selectResourceFromSelectControl"
          :disabled="isLocked || isReadonly"
          :options="availableResources"
          :value="selectedResourceId"
          :selected="selectedResourceId"
          label="display"
        >
          <option value="" selected>{{ placeholder }}</option>
        </select-control>

        <create-relation-button
          v-if="canShowNewRelationModal"
          @click="openRelationModal"
          class="ml-1"
        />
      </div>

      <portal to="modals" transition="fade-transition">
        <create-relation-modal
          v-if="relationModalOpen && canShowNewRelationModal"
          @set-resource="handleSetResource"
          @cancelled-create="closeRelationModal"
          :resource-name="field.resourceName"
          :resource-id="resourceId"
          :via-relationship="viaRelationship"
          :via-resource="viaResource"
          :via-resource-id="viaResourceId"
          width="800"
        />
      </portal>

      <!-- Trashed State -->
      <div v-if="shouldShowTrashed" class="mt-1">
        <checkbox-with-label
          :dusk="`${field.resourceName}-with-trashed-checkbox`"
          :checked="withTrashed"
          @input="toggleWithTrashed"
        >
          {{ __('With Trashed') }}
        </checkbox-with-label>
      </div>
    </template>
  </default-field>
</template>

<script>
    import BelongsToField from "@nova/components/Form/BelongsToField";

    export default {
        extends: BelongsToField
    }
</script>
