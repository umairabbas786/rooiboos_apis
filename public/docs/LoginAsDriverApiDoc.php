<?php


class LoginAsDriverApiDoc extends ApiDoc {

    function onGeneralMeta() { ?>
        <div class="api-general-meta">
            <h2 class="api-title mt-5">Login As Driver</h2>
            <div class="api-meta">
                <p class="api-method">POST</p>
                <p class="end-point">login_as_driver.php</p>
            </div>
        </div>
    <?php }

    function onParamsDoc() { ?>
        <table class="table table-bordered params-table">
            <tr>
                <th>Param</th>
                <th>type</th>
                <th>Required</th>
                <th>Value</th>
                <th>Description</th>
            </tr>
            <tr>
                <td>phone</td>
                <td>String</td>
                <td>True</td>
                <td>+92xxxxxxxxx</td>
                <td>Phone Number of Driver</td>
            </tr>
        </table>
    <?php }

    function onResponseDoc() { ?>
        <p class="mt-4">Following response comes if you forget to pass the parameter.</p>
        <pre class="response-box"><code class="language-json kill-as-bad-request <?php $this->getUniqueClass() ?>"></code></pre>
        <script>
            document.querySelector('.<?php $this->getUniqueClass(); ?>').innerHTML = JSON.stringify({
                "cab_5_response_code": 400,
                "cab_5_error": "BAD_REQUEST",
            }, null, '\t')
        </script>

        <p class="mt-4">Following response comes if driver is not found.</p>
        <pre class="response-box"><code class="language-json kill-as-bad-request <?php $this->getUniqueClass() ?>"></code></pre>
        <script>
            document.querySelector('.<?php $this->getUniqueClass(); ?>').innerHTML = JSON.stringify({
                "cab_5_response_code": 200,
                "cab_5_error": "NONE",
                "data": {
                    "user": null
                }
            }, null, '\t')
        </script>

        <p class="mt-4">Following response comes if user is found. <br /><span class="param">cnic</span>, <span class="param">license</span>, and <span class="param">number_plate</span> will be NULL if not uploaded.</p>
        <pre class="response-box"><code class="language-json kill-as-bad-request <?php $this->getUniqueClass() ?>"></code></pre>
        <script>
            document.querySelector('.<?php $this->getUniqueClass(); ?>').innerHTML = JSON.stringify({
                "cab_5_response_code": 200,
                "cab_5_error": "NONE",
                "authorization_token": {
                    "abracadabra": "c2681e0859efb69b627b96ad765222",
                    "token": "hIJguKH04gDC35VrlpiNdw==.T29OOHVyWkVveFBCYURiZTJYazV4Zk04S3R2dktGZGx..."
                },
                "data": {
                    "user": {
                        "id": 1,
                        "first_name": "Attaullah",
                        "last_name": "Khan",
                        "username": "",
                        "email": "attaullahkhanlodhi@gmail.com",
                        "password": "",
                        "abracadabra": "",
                        "phone": "+923474350557",
                        "verified_email": false,
                        "verified_phone": true,
                        "created_at": "2021-08-19 16:40:18",
                        "updated_at": "2021-08-19 16:40:18",
                        "role": "DRIVER",
                        "token": "cac8861ebc1f2fc20fa252b4d1bc0fcf0439137b62fa50d1dc1f1f..."
                    },
                    "city": {
                        "id": 1,
                        "name": "Miani",
                        "created_at": "2021-08-19 13:24:03",
                        "updated_at": "2021-08-19 13:24:03"
                    },
                    "ride_category": {
                        "id": 1,
                        "name": "Business",
                        "enabled": true,
                        "image": "http://192.168.43.175/data/images/ride_categories/162936902558425.jpg",
                        "created_at": "2021-08-19 15:30:25",
                        "updated_at": "2021-08-19 15:30:25"
                    },
                    "avatar": {
                        "id": 1,
                        "avatar": "http://192.168.43.175/data/images/avatars/16293732187711.jpg",
                        "created_at": "2021-08-19 16:40:18",
                        "updated_at": "2021-08-19 16:40:18"
                    },
                    "cnic": {
                        "id": 1,
                        "user_id": 1,
                        "cnic_front": "http://192.168.43.175/data/images/driver_cnic/162937957518595.jpg",
                        "cnic_back": "http://192.168.43.175/data/images/driver_cnic/16293795754907.jpg",
                        "created_at": "2021-08-19 18:26:15",
                        "updated_at": "2021-08-19 18:26:15"
                    },
                    "license": {
                        "id": 1,
                        "user_id": 1,
                        "license_front": "http://192.168.43.175/data/images/driver_license/162939086326133.jpg",
                        "license_back": "http://192.168.43.175/data/images/driver_license/162939086352903.jpg",
                        "created_at": "2021-08-19 21:34:23",
                        "updated_at": "2021-08-19 21:34:23"
                    },
                    "number_plate": {
                        "id": 1,
                        "user_id": 1,
                        "number_plate": "http://192.168.43.175/data/images/vehicle_number_plates/162945272955470.jpg",
                        "created_at": "2021-08-20 14:45:29",
                        "updated_at": "2021-08-20 14:45:29"
                    }
                }
            }, null, '\t')
        </script>
    <?php }
}