<?php

    namespace BaBeuloula;


    /**
     * Class HighchartsExport
     *
     * Permet d'exporter des graphiques Highcharts via leur API
     *
     * @package BaBeuloula
     */
    class HighchartsExport {

        /**
         * @param array  $options
         * @param string $type ("image/png", "image/jpeg", "image/svg+xml", "application/pdf")
         * @param string $width
         * @param string $scale
         * @param string $constr ("Chart", "StockChart", "Map")
         *
         * @return string
         * @throws \Exception
         */
        public static function export($options = array(), $type = 'image/svg+xml', $width = '', $scale = '', $constr = 'Chart') {
            $endpoint = 'http://export.highcharts.com/';
            
            $types = array(
                "image/png",
				"image/jpeg",
				"image/svg+xml",
				"application/pdf",
            );

            if(!in_array($type, $types)) {
                throw new \Exception('Error type export');
            }

            $constrs = array(
                "Chart",
                "StockChart",
                "Map",
            );

            if(!in_array($constr, $constrs)) {
                throw new \Exception('Error constr export');
            }

            $params = array(
                'async'   => true,
                'content' => 'options',
                'options' => json_encode($options),
                'width'   => $width,
                'scale'   => $scale,
                'type'    => $type,
                'constr'  => $constr
            );

            $params = http_build_query($params);

            $curl = curl_init();

            curl_setopt_array($curl, array(
                CURLOPT_URL            => $endpoint,
                CURLOPT_POST           => 1,
                CURLOPT_POSTFIELDS     => $params,
                CURLOPT_RETURNTRANSFER => 1,
                CURLOPT_SSL_VERIFYPEER => false,
                CURLOPT_SSL_VERIFYHOST => false,
                CURLOPT_VERBOSE        => 1
            ));

            $response = curl_exec($curl);

            curl_close($curl);

            if (FALSE === $response) {
                throw new \Exception('Error export Highcharts');
            } else {
                return file_get_contents($endpoint . $response);
            }
        }
    }
