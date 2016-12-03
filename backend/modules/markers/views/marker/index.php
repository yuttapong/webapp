<?php
/**
 * Yii Google Maps markers
 *
 * @author Marc Oliveras Galvez <oligalma@gmail.com> 
 * @link http://www.ho96.com
 * @copyright 2016 Hosting 96
 * @license New BSD License
 */
 
use yii\helpers\Html;
use yii\web\View;
?>
<div class="center margin-bottom-20" style="text-align:center;">
    <?= Html::a('Create marker', array('marker/create', 'lang' => Yii::$app->language)) ?>
</div>
<?php
if(count($markers) > 0):
?>
<table cellspacing="0" cellpadding="0" class="center margin-bottom-20" id="markers-table">
    <tr>
        <th>
            Longitude
        </th>
        <th>
            Latitude
        </th>
        <th>
            Text
        </th>
        <th>
            
        </th>
        <th>
            
        </th>
    </tr>
<?php
    foreach($markers as $marker):        
?>
    <tr>
        <td>
            <?= $marker->longitude ?>
        </td>
        <td>
            <?= $marker->latitude ?>
        </td>
        <td>
            <?= substr(strip_tags($marker->text),0,20) . (strlen(strip_tags($marker->text)) > 20 ? '...' : '') ?>
        </td>
        <td>
            <?= Html::a(Html::img(Yii::$app->controller->module->assetsUrl . '/images/edit.png'), array('marker/update', 'id' => $marker->id)) ?>
        </td>
        <td>
            <?= Html::a(Html::img(Yii::$app->controller->module->assetsUrl . '/images/delete.png'), array('marker/delete', 'id' => $marker->id)) ?>
        </td>
    </tr>
<?php
    endforeach;
?>
</table>
<div id="map_wrapper" class="margin-top-20">
    <div id="map_canvas" class="mapping"></div>
</div>
<?php
    $this->registerJsFile('https://maps.googleapis.com/maps/api/js?sensor=false&callback=initialize', ['depends' => [\yii\web\JqueryAsset::className()]]);
    $this->registerCssFile(Yii::$app->controller->module->assetsUrl . '/css/markers.css', [], 'markerscss');

    $markersJs = '';
    $infoWindowJs = '';
    $iconsJs = '';
    foreach($markers as $marker):               
       $markersJs .= '[\'\',' . $marker->longitude . ',' . $marker->latitude . '],';
       $infoWindowJs .= '[\'' . preg_replace( "/\r|\n/", "", str_replace('\'', '&#39;', $marker->text)) . '\'],';
       $iconsJs .= '[\'' . $marker->icon . '\'],';
    endforeach;
                          
    $this->registerJs('
        // The following Google Maps Code has been taken from http://wrightshq.com
        var map;
        var bounds = new google.maps.LatLngBounds();
        var mapOptions = {
            mapTypeId: \'roadmap\'
        };
                        
        // Display a map on the page
        map = new google.maps.Map(document.getElementById("map_canvas"), mapOptions);
        map.setTilt(45);
            
        // Multiple Markers
        var markers = [' . $markersJs . '];
        var infoWindowContent = [' . $infoWindowJs . '];
        var icons = [' . $iconsJs . '];
        
        // Display multiple markers on a map
        var infoWindow = new google.maps.InfoWindow(), marker, i;
        
        // Loop through our array of markers & place each one on the map  
        for( i = 0; i < markers.length; i++ ) {
            var position = new google.maps.LatLng(markers[i][1], markers[i][2]);
            bounds.extend(position);
            marker = new google.maps.Marker({
                position: position,
                map: map,
                title: markers[i][0],
                icon: \'' . Yii::$app->controller->module->assetsUrl . '/images/icons/\'' . '+ icons[i]
            });
            
            // Allow each marker to have an info window    
            google.maps.event.addListener(marker, \'click\', (function(marker, i) {
                return function() {
                    infoWindow.setContent(infoWindowContent[i][0]);
                    infoWindow.open(map, marker);
                }
            })(marker, i));
    
            // Automatically center the map fitting all markers on the screen
            map.fitBounds(bounds);
        }
    
        // Override our map zoom level once our fitBounds function runs (Make sure it only runs once)
        var boundsListener = google.maps.event.addListener((map), \'bounds_changed\', function(event) {
            ' . 
            (count($markers) == 1 ? 'this.setZoom(17)' : '')
           . '
            google.maps.event.removeListener(boundsListener);
        });
    ',View::POS_END, 'markersjs');
endif;
?>
