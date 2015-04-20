<?php

class ControllerShippingNovaPoshta extends Controller
{
    private $apiUrl = 'https://api.novaposhta.ua/v2.0/xml/';
    private $error = array();

    public function index()
    {

        $this->load->language('shipping/novaposhta');

        $this->document->setTitle($this->language->get('heading_title'));

        $this->load->model('setting/setting');

        if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validate()) {
            $this->model_setting_setting->editSetting('novaposhta', $this->request->post);

            $this->session->data['success'] = $this->language->get('text_success');

            $this->redirect($this->url->link('extension/shipping', 'token=' . $this->session->data['token'], 'SSL'));
        }

        $this->data['token'] = $this->session->data['token'];

        $this->data['heading_title'] = $this->language->get('heading_title');

        $this->data['text_enabled'] = $this->language->get('text_enabled');
        $this->data['text_disabled'] = $this->language->get('text_disabled');
        $this->data['text_all_zones'] = $this->language->get('text_all_zones');
        $this->data['text_none'] = $this->language->get('text_none');
        $this->data['text_select'] = $this->language->get('text_select');

        $this->data['entry_cost'] = $this->language->get('entry_cost');
        $this->data['entry_sender_warehouse'] = $this->language->get('entry_sender_warehouse');
        $this->data['entry_geo_zone'] = $this->language->get('entry_geo_zone');
        $this->data['entry_status'] = $this->language->get('entry_status');
        $this->data['entry_sort_order'] = $this->language->get('entry_sort_order');
        $this->data['entry_api_key'] = $this->language->get('entry_api_key');
        $this->data['entry_sender_city'] = $this->language->get('entry_sender_city');
        $this->data['entry_comment'] = $this->language->get('entry_comment');
        $this->data['entry_send_order_status'] = $this->language->get('entry_send_order_status');
        $this->data['entry_sender_organization'] = $this->language->get('entry_sender_organization');
        $this->data['entry_sender_person'] = $this->language->get('entry_sender_person');
        $this->data['entry_sender_phone'] = $this->language->get('entry_sender_phone');

        $this->data['button_save'] = $this->language->get('button_save');
        $this->data['button_cancel'] = $this->language->get('button_cancel');

        if (isset($this->error['warning'])) {
            $this->data['error_warning'] = $this->error['warning'];
        } else {
            $this->data['error_warning'] = '';
        }

        $this->data['breadcrumbs'] = array();

        $this->data['breadcrumbs'][] = array(
            'text' => $this->language->get('text_home'),
            'href' => $this->url->link('common/home', 'token=' . $this->session->data['token'], 'SSL'),
            'separator' => false
        );

        $this->data['breadcrumbs'][] = array(
            'text' => $this->language->get('text_shipping'),
            'href' => $this->url->link('extension/shipping', 'token=' . $this->session->data['token'], 'SSL'),
            'separator' => ' :: '
        );

        $this->data['breadcrumbs'][] = array(
            'text' => $this->language->get('heading_title'),
            'href' => $this->url->link('shipping/novaposhta', 'token=' . $this->session->data['token'], 'SSL'),
            'separator' => ' :: '
        );

        $this->data['action'] = $this->url->link('shipping/novaposhta', 'token=' . $this->session->data['token'], 'SSL');

        $this->data['cancel'] = $this->url->link('extension/shipping', 'token=' . $this->session->data['token'], 'SSL');

        if (isset($this->request->post['novaposhta_api_key'])) {
            $this->data['novaposhta_api_key'] = $this->request->post['novaposhta_api_key'];
        } else {
            $this->data['novaposhta_api_key'] = $this->config->get('novaposhta_api_key');
        }

        if (isset($this->request->post['novaposhta_sender_organization'])) {
            $this->data['novaposhta_sender_organization'] = $this->request->post['novaposhta_sender_organization'];
        } else {
            $this->data['novaposhta_sender_organization'] = $this->config->get('novaposhta_sender_organization');
        }

        if (isset($this->request->post['novaposhta_sender_person'])) {
            $this->data['novaposhta_sender_person'] = $this->request->post['novaposhta_sender_person'];
        } else {
            $this->data['novaposhta_sender_person'] = $this->config->get('novaposhta_sender_person');
        }

        if (isset($this->request->post['novaposhta_sender_phone'])) {
            $this->data['novaposhta_sender_phone'] = $this->request->post['novaposhta_sender_phone'];
        } else {
            $this->data['novaposhta_sender_phone'] = $this->config->get('novaposhta_sender_phone');
        }

        if (isset($this->request->post['novaposhta_geo_zone_id'])) {
            $this->data['novaposhta_geo_zone_id'] = $this->request->post['novaposhta_geo_zone_id'];
        } else {
            $this->data['novaposhta_geo_zone_id'] = $this->config->get('novaposhta_geo_zone_id');
        }

        if (isset($this->request->post['novaposhta_comment'])) {
            $this->data['novaposhta_comment'] = $this->request->post['novaposhta_comment'];
        } else {
            $this->data['novaposhta_comment'] = $this->config->get('novaposhta_comment');
        }


        if (isset($this->request->post['novaposhta_sender_city'])) {
            $this->data['novaposhta_sender_city'] = $this->request->post['novaposhta_sender_city'];
        } else {
            $this->data['novaposhta_sender_city'] = $this->config->get('novaposhta_sender_city');
        }

        if (isset($this->request->post['novaposhta_sender_city_name'])) {
            $this->data['novaposhta_sender_city_name'] = $this->request->post['novaposhta_sender_city_name'];
        } else {
            $this->data['novaposhta_sender_city_name'] = $this->config->get('novaposhta_sender_city_name');
        }

        if (isset($this->request->post['novaposhta_status'])) {
            $this->data['novaposhta_status'] = $this->request->post['novaposhta_status'];
        } else {
            $this->data['novaposhta_status'] = $this->config->get('novaposhta_status');
        }

        if (isset($this->request->post['novaposhta_sort_order'])) {
            $this->data['novaposhta_sort_order'] = $this->request->post['novaposhta_sort_order'];
        } else {
            $this->data['novaposhta_sort_order'] = $this->config->get('novaposhta_sort_order');
        }

        $this->load->model('localisation/order_status');
        $this->data['order_statuses'] = $this->model_localisation_order_status->getOrderStatuses();

        if (isset($this->request->post['novaposhta_send_order_status'])) {
            $this->data['novaposhta_send_order_status'] = $this->request->post['novaposhta_send_order_status'];
        } else {
            $this->data['novaposhta_send_order_status'] = $this->config->get('novaposhta_send_order_status');
        }

        $this->load->model('localisation/geo_zone');

        $this->data['geo_zones'] = $this->model_localisation_geo_zone->getGeoZones();

        $this->load->model('localisation/zone');

        $this->data['zones'] = $this->model_localisation_zone->getZones();
        $this->load->model('localisation/language');
        $this->data['languages'] = $this->model_localisation_language->getLanguages();


        if (isset($this->request->post['novaposhta_sender_warehouse'])) {
            $this->data['novaposhta_sender_warehouse'] = $this->request->post['novaposhta_sender_warehouse'];
        } else {
            $this->data['novaposhta_sender_warehouse'] = $this->config->get('novaposhta_sender_warehouse');
        }


        $this->template = 'shipping/novaposhta.tpl';
        $this->children = array(
            'common/header',
            'common/footer'
        );

        $this->response->setOutput($this->render());
    }

    public function getCities()
    {
        $json = array();
        if ($this->config->get('novaposhta_api_key')) {
            $xml = '<?xml version="1.0" encoding="utf-8" ?>';
            $xml .= '<file>';
            $xml .= '<apiKey>' . $this->config->get('novaposhta_api_key') . '</apiKey>';
            $xml .= '<modelName>Address</modelName>';
            $xml .= '<calledMethod>getCities</calledMethod>';
            $xml .= '</file>';

            $response = $this->getResult($xml);

            if ($response) {
                $xml = simplexml_load_string($response);

                foreach ($xml->data->item as $city) {
                    if ($this->language->get('code') == 'ru') {
                        $cityName = $city->DescriptionRu;
                    } else {
                        $cityName = $city->Description;
                    }
                    $cityRef = $city->Ref;
                    $results[] = array('city' => $cityName, 'ref' => $cityRef);
                }
            }

            if ($results) {
                foreach ($results as $result) {
                    $json[] = array(
                        'city' => (string)$result['city'],
                        'ref' => (string)$result['ref']
                    );
                }
            }
        }
        $this->response->setOutput(json_encode($json));
    }


    public function getWarehouses()
    {
        $json = array();
        if (isset($this->request->get['filter']) && $this->config->get('novaposhta_api_key')) {
            $xml = '<?xml version="1.0" encoding="utf-8" ?>';
            $xml .= '<file>';
            $xml .= '<apiKey>' . $this->config->get('novaposhta_api_key') . '</apiKey>';
            $xml .= '<modelName>Address</modelName>';
            $xml .= '<calledMethod>getWarehouses</calledMethod>';
            $xml .= '<methodProperties>';
            $xml .= '<CityRef>' . $this->request->get['filter'] . '</CityRef>';
            $xml .= '</methodProperties>';
            $xml .= '</file>';

            $response = $this->getResult($xml);

            if ($response) {
                $xml = simplexml_load_string($response);

                foreach ($xml->data->item as $warehouse) {
                    if ($this->language->get('code') == 'ru') {
                        $json[] = array(
                            'warehouse' => (string)str_replace(array('"', "'"), '', $warehouse->DescriptionRu),
                            'number' => (string)str_replace(array('"', "'"), '', $warehouse->Number),
                        );
                    } else {
                        $json[] = array(
                            'warehouse' => (string)str_replace(array('"', "'"), '', $warehouse->Description),
                            'number' => (string)str_replace(array('"', "'"), '', $warehouse->Number),
                        );
                    }
                }
            }
        }

        $this->response->setOutput(json_encode($json));
    }

    private function validate()
    {
        if (!$this->user->hasPermission('modify', 'shipping/novaposhta')) {
            $this->error['warning'] = $this->language->get('error_permission');
        }

        if (!$this->error) {
            return true;
        } else {
            return false;
        }
    }

    private function getResult($request)
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $this->apiUrl);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_HTTPHEADER, Array("Content-Type: text/xml"));
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $request);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
        $response = curl_exec($ch);
        curl_close($ch);

        return $response;
    }
}
