# Tree Builder Project

## Goal

The goal is to create a utility to parse a flat tree of indexes into a nested tree.

1. Fill in the unit test in TreeBuilderTest so that if verifies reasonably well the output.
2. Fill in the TreeBuilder::build function to build your tree.

(see `@FILLTHIS` inside the code)

**Input example**

We want to order un-ordered medicine titles, from flat to nested. As an example, we want to turn...

```
[
    1. Dénomination du médicament
    2.1 Effets sur la grossesse
    2. Effets indésirables
    ...
]
```

into a nested array

```
[
    1 => [ title => "Dénomination du médicament", children => [] ],
    2 => [ title => "Effets indésirables", children => [
        [ title => "2.1 Effets sur la grossesse" ]
        ...
    ] ],
    ...
]
```

Also, comment what you do !

## Hypothesis

- Numbers from input data are always properly formatted as `<num>.<num>.`.
- The maximum level of subtitles is two (as given in examples).
- The texts after numerotations never contain "dots".
- Its doesn't matter if the final nested array has a different form (or keys) as long as it is nested and exploitable.

## Bonus question

How would do write your code differently if you possibly had unlimited number of sublevels and the input was originaly un-ordered ?

## Install

Download or clone, and run `composer install`.

## Run

Run tests suits: `phpunit`.

## Links

- https://phpunit.de/manual/6.5/en/appendixes.assertions.html
