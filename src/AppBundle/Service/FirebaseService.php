<?php

namespace AppBundle\Service;


use JMS\DiExtraBundle\Annotation as DI;

/**
 * Class FirebaseService
 * @package AppBundle\Service
 *
 * @author Gary HOUBRE <gary.houbre@gmail.com>
 *
 * @DI\Service("project.service.firebase")
 */
class FirebaseService
{

	protected $server_key;

	protected $message;


	const FCM_URL = "https://fcm.googleapis.com/fcm/send";


	public function createMessage($message)
	{
		if (!array_key_exists("to", $message)) return false;
		$this->message["to"] = $message["to"];
		if (array_key_exists("title", $message)) {
			$this->message["notification"]["title"] = $message["title"];
		}
		if (array_key_exists("body", $message)) {
			$this->message["notification"]["body"] = $message["body"];
		}
		if (array_key_exists("badge", $message)) {
			$this->message["notification"]["badge"] = $message["badge"];
		}
		if (array_key_exists("sound", $message)) {
			$this->message["notification"]["sound"] = $message["sound"];
		}

		$this->message["content_available"] = true;

		$this->message["time_to_live"] = 30;

		return true;
	}

	public function sendMessage()
	{
		$content = json_encode($this->message);

		$curl = curl_init(self::FCM_URL);
		curl_setopt($curl, CURLOPT_HEADER, false);
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($curl, CURLOPT_HTTPHEADER, array(
				"Content-type: application/json",
				"Authorization: key=".$this->server_key
			)
		);
		curl_setopt($curl, CURLOPT_POST, true);
		curl_setopt($curl, CURLOPT_POSTFIELDS, $content);

		$json_response = curl_exec($curl);

		$status = curl_getinfo($curl, CURLINFO_HTTP_CODE);
		if ( $status != 200 ) {}

		curl_close($curl);
		$response = json_decode($json_response, true);
		$result = [
			'status' 	=> $status,
			'response' 	=> $response
		];

		return $result;
	}

	/**
	 * @param array $array
	 * @return array
	 *
	 * Custom function for firebaseService
	 */
	public function sendMessageFromForm(Array $array, $serverKey)
	{
		$this->server_key = $serverKey;
		$this->createMessage($array);

		$response = $this->sendMessage();

		return $response;

	}


}