<?php
include("../bd/config.php");
Class maps{
        public function get_distance($lat_ini, $lng_ini, $lat_fim, $lng_fim){
            $url = 'https://maps.googleapis.com/maps/api/directions/json?origin='.$lat_ini.','.$lng_ini.'&destination='.$lat_fim.','.$lng_fim.'&key='.KEY_GOOGLE_MAPS.'&language=pt-BR&region=BR&mode=driving';
            $json = file_get_contents($url);
            $obj = json_decode($json);
            $km = $obj->routes[0]->legs[0]->distance->value;
            $km = $km / 1000;
            $minutos = $obj->routes[0]->legs[0]->duration->value;
            $minutos = $minutos / 60;
            $dados = array();
            $dados['km'] = $km;
            $dados['minutos'] = $minutos;
            return $dados;
        }

        public function get_distance_address($endereco_ini, $endereco_fim){
            $url = 'https://maps.googleapis.com/maps/api/directions/json?origin='.$endereco_ini.'&destination='.$endereco_fim.'&key='.KEY_GOOGLE_MAPS.'&language=pt-BR&region=BR&mode=driving';
            $json = file_get_contents($url);
            $obj = json_decode($json);
            $km = $obj->routes[0]->legs[0]->distance->value;
            $km = $km / 1000;
            $minutos = $obj->routes[0]->legs[0]->duration->value;
            $minutos = $minutos / 60;
            $dados = array();
            $dados['km'] = $km;
            $dados['minutos'] = $minutos;
            return $dados;
        }
    
}