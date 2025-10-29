# Mars Rover

Un escuadrón de rovers robóticos será desplegado por NASA en una meseta en Marte.

Esta meseta, que curiosamente es rectangular, debe ser navegada por los rovers para que sus cámaras a bordo puedan
obtener una vista completa del terreno circundante y enviarla de vuelta a la Tierra.

La posición de un rover se representa mediante una combinación de coordenadas `x` e `y` y una letra que representa uno
de los cuatro puntos cardinales de la brújula. La meseta está dividida en una cuadrícula para simplificar la navegación.
Una posición de ejemplo podría ser `0, 0, N`, lo que significa que el rover está en la esquina inferior izquierda y
mirando hacia el Norte.

Para controlar un rover, NASA envía una simple cadena de letras. Las letras posibles son `L`, `R` y `M`.
`L` y `R` hacen que el rover gire 90 grados a la izquierda o derecha respectivamente, sin moverse de su posición actual.
`M` significa avanzar un punto de la cuadrícula y mantener la misma dirección.

Asume que el cuadrado directamente al Norte de `(x, y)` es `(x, y+1)`.

## Requisitos

Desarrolla una API que mueva un rover en una meseta.

### Input:

La primera línea de input son las coordenadas superiores derechas de la meseta, las coordenadas inferiores izquierdas se
asumen como 0,0.

El resto del input es información relacionada con los rovers que han sido desplegados. Cada rover tiene dos líneas de
input. La primera línea indica la posición del rover, y la segunda línea es una serie de instrucciones que le indican al
rover cómo explorar la meseta.

La posición está compuesta por dos números enteros y una letra separados por espacios, correspondientes a las
coordenadas x e y y la orientación del rover.

Cada rover terminará secuencialmente, lo que significa que el segundo rover no comenzará a moverse hasta que el primero
haya terminado de moverse.

### Output:

El output para cada rover debe ser sus coordenadas finales y su orientación.

### Ejemplo

| Posición de origen | Comandos     | Posición final  |
|--------------------|--------------|-----------------|
| `x: 1, y: 2, N`    | `LMLMLMLMM`  | `x: 1, y: 3, N` |
| `x: 3, y: 3, E`    | `MMRMMRMRRM` | `x: 5, y: 1, E` |

