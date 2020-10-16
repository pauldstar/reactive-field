<?php

namespace FifteenGroup\NovaCompactUi\Http\Controllers;

use Illuminate\Routing\Controller;
use Laravel\Nova\Fields\FieldCollection;
use Laravel\Nova\Http\Requests\NovaRequest;

class ReactiveFieldController extends Controller
{
    public function __invoke(NovaRequest $request, string $resource, string $field)
    {
        $novaResource = $request->get('resourceId')
            ? $request->newResourceWith($request->findModelOrFail())
            : $request->newResource();

        $availableFields = $novaResource->availableFields($request);

        $listener = $this->getResource($field, $availableFields);

        if (empty($listener)) {
            abort(404, "Unable to find the field required to calculate this value");
        }

        $request->merge($this->customFields($request, $availableFields));

        $calculatedValue = is_callable($listener->broadcastHandler)
            ? call_user_func(
                $listener->broadcastHandler,
                collect($request->all()),
                $request
            )
            : $listener->broadcastHandler;

        return response()->json([
            'value' => $calculatedValue
        ]);
    }

    private function getResource(string $field, FieldCollection $availableFields)
    {
        return $availableFields->firstWhere('attribute', $field);
    }

    private function customFields(NovaRequest $request, FieldCollection $availableFields): array
    {
        return $availableFields
            ->whereIn('attribute', array_keys($request->except('resourceId')))
            ->flatMap($this->customFieldValues($request))
            ->toArray();
    }

    private function customFieldValues(NovaRequest $request): callable
    {
        return function ($field) use ($request) {
            $customFields = [];

            if (isset($field->customFields)) {
                foreach($field->customFields as $custom => $callback) {
                    $customFields[$custom] = call_user_func(
                        $callback,
                        $request->get($field->attribute),
                        $request
                    );
                }
            }

            return $customFields;
        };
    }
}
