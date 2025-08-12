<?php

namespace App\View\Components;

use Illuminate\View\Component;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;

class UfValue extends Component
{
    public $ufValue;

    public function __construct()
    {
        $this->ufValue = $this->fetchUfValue();
    }

    private function fetchUfValue()
    {
        $client = new Client();
        $apiKey = '8b01031fe1bea472cc0dc9a947d19970689b9558'; // Reemplaza con tu API Key
        $url = "https://api.cmfchile.cl/api-sbifv3/recursos_api/uf?apikey={$apiKey}&formato=json";

        try {
            $response = $client->get($url);
            $data = json_decode($response->getBody(), true);

            // Verifica si la estructura de la respuesta contiene el valor de la UF
            if (isset($data['UFs'][0]['Valor'])) {
                return '$' . $data['UFs'][0]['Valor']; // Devuelve el valor de la UF
            } else {
                return 'No disponible'; // Mensaje por defecto si no se encuentra el valor
            }
        } catch (RequestException $e) {
            return 'Error: ' . $e->getMessage(); // Manejo de excepciones
        }
    }

    public function render()
    {
        return view('components.uf-value');
    }
}
