<?php

require_once('class.exception.php');
require_once('class.baseclient.php');

class HubspotClass extends HubSpot_Baseclient{

	private $hpaiKey;
	private $baseUrl= 'http://api.hubapi.com/';
	private $contentPath= 'content/';
	private $contactPath= 'contacts/';
	private $apiVersion= 'api/v2/';
	private $portalId= '<Portal ID>';

	public function __construct($hpiKey)
	{
		$this->hpiKey = $hpiKey;
	}

	public function upload_new_template($body, $path)
	{
		$url = $this->baseUrl . $this->contentPath . $this->apiVersion . 'templates?hapikey=' . $this->hpiKey;
		return $this->execute_JSON_post_request($url, json_encode(
			array(
			"category_id" => 1,
			"folder" => "examples",
		    "template_type" =>  <type_of_template>,        
		    "path" => $path,         
		    "source" => $body,
			)
		));
	}

	public function update_template($templateId, $body)
	{
		$url = $this->baseUrl . $this->contentPath . $this->apiVersion . 'templates/' . $templateId . '?hapikey=' . $this->hpiKey;
		return $this->execute_put_request($url, json_encode(
			array(        
		    "source" => $body,
			)
		));
	}

	public function get_all_templates($folder)
	{
		$url = $this->baseUrl . $this->contentPath . $this->apiVersion . 'templates?hapikey=' . $this->hpiKey . '&folder=' . $folder;
		return $this->execute_get_request($url);
	}

	public function get_contact_by_token($token)
	{
		$url = $this->baseUrl . $this->contactPath . 'v1/contact/utk/' . $token . '/profile?hapikey=' . $this->hpiKey;
		return json_decode($this->execute_get_request($url));
	}

	public function update_contact_by_email($email, $params)
	{
		$properties= array();
		foreach ($params as $key => $value) {
    		array_push($properties, array("property"=>$key,"value"=>$value));
    	}
    	$properties = json_encode(array("properties"=>$properties));
		$url= $this->baseUrl . $this->contactPath . 'v1/contact/createOrUpdate/email/' . $email . '/profile?hapikey=' . $this->hpiKey;
		return $this->execute_JSON_post_request($url, $properties);
	}

	public function get_contact_by_ids($vids)
	{
		$url = $this->baseUrl . $this->contactPath . 'v1/contact/vids/batch/?portalId='.$this->portalId . '&' . $vids . '&hapikey=' . $this->hpiKey;
		return json_decode($this->execute_get_request($url));
	}

	public function get_campaigns($limit= 3)
	{
		$url = $this->baseUrl . 'email/public/v1/campaigns/?hapikey=' . $this->hpiKey . '&limit=' . $limit;
		return json_decode($this->execute_get_request($url));
	}

	public function get_campaign_data($cid)
	{
		$url = $this->baseUrl . 'email/public/v1/campaigns/' . $cid . '?appId='.$this->portalId . '&hapikey=' . $this->hpiKey;
		return json_decode($this->execute_get_request($url));
	}

	public function get_contact_by_email($emails)
	{
		$url = $this->baseUrl . $this->contactPath . 'v1/contact/emails/batch/?portalId='.$this->portalId . '&' . $emails . '&hapikey=' . $this->hpiKey;
		return json_decode($this->execute_get_request($url));
	}

	public function get_property_by_name($name)
	{
		$url = $this->baseUrl . $this->contactPath . 'v2/properties/named/' . $name . '?portalId='.$this->portalId . '&' . $emails . '&hapikey=' . $this->hpiKey;
		return json_decode($this->execute_get_request($url));
	}

	public function update_contact_property($name, $params)
	{
		$url= $this->baseUrl . $this->contactPath . 'v2/properties/named/' . $name . '?hapikey=' . $this->hpiKey . '&portalId=' . $this->portalId;
		return json_decode($this->execute_put_request($url, json_encode($params)));
	}

	public function create_contact_property($params)
	{
		$url= $this->baseUrl . $this->contactPath . 'v2/properties?hapikey=' . $this->hpiKey . '&portalId=' . $this->portalId;
		return json_decode($this->execute_JSON_post_request($url, json_encode($params)));
	}

	public function create_or_update_contact($email, $params)
	{
		$properties= array();
		foreach ($params as $key => $value) {
    		array_push($properties, array("property"=>$key,"value"=>$value));
    	}
    	$properties = json_encode(array("properties"=>$properties));
		$url= $this->baseUrl . $this->contactPath . 'v1/contact/createOrUpdate/email/' . $email . '/?hapikey=' . $this->hpiKey;
		return $this->execute_JSON_post_request($url, $properties);
	}

}
