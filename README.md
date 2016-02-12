# Highcharts PHP
Convertissez vos graphiques Highcharts en images via PHP

## Important
Si vous souhaitez convertir du SVG en JPG ou autre, il vous faudra la librairie PHP **Imagick**.
Si vous souhaitez avoir du JPG ou du PNG, vous pouvez utiliser la librairie GD pour faire vos traitement. 

**Seul problème avec le JPG, de base Highcharts le compresse, il est donc préférable de récupérer l'image en PNG puis de la modifier avec GD pour ne pas perdre en qualité.**

## Paramètres

```php
\BaBeuloula\HighchartsExport::export($options = array(), $type = 'image/svg+xml', $width = '', $scale = '', $constr = 'Chart')
```
- *$options*: Tableau contenant les options que vous passez normalement à Highcharts dans votre JavaScript. **Pensez juste à désactiver l'animation des graphiques**
- *$type*: Type d'image de sortie ("image/png", "image/jpeg", "image/svg+xml", "application/pdf")
- *$width*: Largeur de votre image (2000px maximum). Highcharts met une width par defaut de 600px
- *$scale*: L'échelle pour une résolution d'image supérieure. L'échelle maximum est fixé à 4x. Le paramètre de *$width* a une priorité plus élevée sur l'échelle.
- *$constr*: Le constructeur de graphique (Highcharts: *Chart*, Highstock: *StockChart* ou Highmap: *Map*)

## Exemple
```php
require 'src/HighchartsExport.php'

$options = array(
  'xAxis' => array(
    'categories' => array('Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'),
  ),
  'series' => array(
    array(
      'data' => array(29.9, 71.5, 106.4, 129.2, 144.0, 176.0, 135.6, 148.5, 216.4, 194.1, 95.6, 54.4),
    ),
  ),
);

$svg = \BaBeuloula\HighchartsExport::export($options);

// Utilisation de Imagick, l'outil peut très bien être utilisé avec la librairie GD.
$image = new Imagick();
$image->readImageBlob($svg);
$image->setImageFormat("jpg");

$base64 = 'data:image/' . $image->getImageFormat() . ';base64,' . base64_encode($image->getImageBlob());
```

## Résultat
![export](https://cloud.githubusercontent.com/assets/4849233/13009854/fa666cbc-d19e-11e5-9f67-0fe45ae45002.png)
