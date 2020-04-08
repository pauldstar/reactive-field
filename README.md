# Nova Calculated Field
An extension of the [**codebykyle/calculated-field**](https://codebykyle.com/blog/laravel-nova-custom-calculated-field) package ([github](https://github.com/codebykyle/calculated-field)), but with more field types.

All fields (except ListenerBelongsTo) in this repo behave similarly to fields in that package. Main difference is the renaming of the **calculateWith()** function to **set()**.

Similar to **codebykyle/calculated-field**, this repo contains 2 types of fields:
* Broadcasters, with **broadcastTo(string $channel)**
* Listeners, with **listensTo(string $channel)** and **set(callable $callback)**.

For listeners, the callback function in **set(callable $callback)** is provided values from broadcasters (Collection $values), then calculates and returns a value for the listener field.

The only field that has extra is the **ListenerBelongsTo** field.

It has a **dependsOn(string fieldName)** function that loads resources based on the values returned from **ONE** broadcaster. It's a neat idea inspired by [
**manmohanjit/nova-belongs-to-dependency**](https://novapackages.com/packages/manmohanjit/nova-belongs-to-dependency)
