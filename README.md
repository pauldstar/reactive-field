# Nova Calculated Field
An extension of the [**codebykyle/calculated-field**](https://codebykyle.com/blog/laravel-nova-custom-calculated-field) package ([github](https://github.com/codebykyle/calculated-field)), with more field types.

Unlike **codebykyle/calculated-field**, each field has listening and broadcast capabilities:
* To broadcast, use **->emit(string $event)**
* To listen, first specify th event to listen for **->on(string|string[] $event)** then handle it with **->handle(callable $callback)**.

For the listening field, the callback function in **->handle(callable $callback)** is provided with a collection of values from broadcasters **(Collection $values)**, then calculates and returns a new value for the listener field.

The only field that has extra is the **ReactiveBelongsTo** field.

It's a neat idea inspired by [**manmohanjit/nova-belongs-to-dependency**](https://novapackages.com/packages/manmohanjit/nova-belongs-to-dependency)
It has a **dependsOn(string fieldName)** function that filters related resources (for the belongsTo select-field), based on the value(s) returned from **ONE** broadcaster.
