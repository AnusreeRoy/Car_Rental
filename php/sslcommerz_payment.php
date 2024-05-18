<?php

class SSLCommerz {
    private $store_id = "carle6646733d6f116";
    private $store_passwd = "carle6646733d6f116@ssl";
    private $is_live = true; // Change to true for live environment

    public function initiate($post_data) {
        if ($this->is_live) {
            $url = "https://securepay.sslcommerz.com/gwprocess/v4/api.php";
        } else {
            $url = "https://sandbox.sslcommerz.com/gwprocess/v4/api.php";
        }

        $post_data['store_id'] = $this->store_id;
        $post_data['store_passwd'] = $this->store_passwd;

        $handle = curl_init();
        curl_setopt($handle, CURLOPT_URL, $url);
        curl_setopt($handle, CURLOPT_TIMEOUT, 30);
        curl_setopt($handle, CURLOPT_CONNECTTIMEOUT, 30);
        curl_setopt($handle, CURLOPT_POST, 1);
        curl_setopt($handle, CURLOPT_POSTFIELDS, $post_data);
        curl_setopt($handle, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($handle, CURLOPT_SSL_VERIFYPEER, FALSE); // KEEP IT FALSE IF YOU RUN FROM LOCAL PC

        $content = curl_exec($handle);

        $code = curl_getinfo($handle, CURLINFO_HTTP_CODE);

        if ($code == 200 && !(curl_errno($handle))) {
            curl_close($handle);
            $sslcommerzResponse = json_decode($content, true);
            return $sslcommerzResponse;
        } else {
            curl_close($handle);
            return array("status" => "FAILED", "message" => "Failed to connect with SSLCommerz API");
        }
    }
}

?>
