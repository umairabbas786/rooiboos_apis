<?php


class RegisterAsDriverApiDoc extends ApiDoc {

    function onGeneralMeta() { ?>
        <div class="api-general-meta">
            <h2 class="api-title mt-5">Register As Driver</h2>
            <div class="api-meta">
                <p class="api-method">POST</p>
                <p class="end-point">register_as_driver.php</p>
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
                <td>Phone no. of driver</td>
            </tr>
            <tr>
                <td>first_name</td>
                <td>String</td>
                <td>True</td>
                <td> --------- </td>
                <td>First Name of Driver</td>
            </tr>
            <tr>
                <td>last_name</td>
                <td>String</td>
                <td>True</td>
                <td> --------- </td>
                <td>Last Name of Driver</td>
            </tr>
            <tr>
                <td>email</td>
                <td>String</td>
                <td>True</td>
                <td> --------- </td>
                <td>Email of Driver</td>
            </tr>
            <tr>
                <td>city_id</td>
                <td>String</td>
                <td>True</td>
                <td> --------- </td>
                <td>City ID of driver</td>
            </tr>
            <tr>
                <td>ride_category_id</td>
                <td>String</td>
                <td>True</td>
                <td> --------- </td>
                <td>Ride Category ID of driver</td>
            </tr>
            <tr>
                <td>avatar</td>
                <td>Multipart</td>
                <td>True</td>
                <td> --------- </td>
                <td>Avatar of Driver</td>
            </tr>
        </table>
    <?php }

    function onResponseDoc() { ?>
        <p class="mt-4">Following response comes if you forget to pass a parameter, or if the value of parameter is invalid.</p>
        <pre class="response-box"><code class="language-json kill-as-bad-request <?php $this->getUniqueClass() ?>"></code></pre>
        <script>
            document.querySelector('.<?php $this->getUniqueClass(); ?>').innerHTML = JSON.stringify({
                "cab_5_response_code": 400,
                "cab_5_error": "BAD_REQUEST",
            }, null, '\t')
        </script>

        <p class="mt-4">Following response comes if you provided a <span class="param">ride_category_id</span> and it has been deleted on server.</p>
        <pre class="response-box"><code class="language-json kill-as-bad-request <?php $this->getUniqueClass() ?>"></code></pre>
        <script>
            document.querySelector('.<?php $this->getUniqueClass(); ?>').innerHTML = JSON.stringify({
                "cab_5_response_code": 410,
                "cab_5_error": "Gone",
                "data": {
                    "exceptions": {
                        "requested_ride_category_is_no_more_available": true
                    }
                }
            }, null, '\t')
        </script>

        <p class="mt-4">Following response comes if you provided a <span class="param">city_id</span> and it has been deleted on server.</p>
        <pre class="response-box"><code class="language-json kill-as-bad-request <?php $this->getUniqueClass() ?>"></code></pre>
        <script>
            document.querySelector('.<?php $this->getUniqueClass(); ?>').innerHTML = JSON.stringify({
                "cab_5_response_code": 410,
                "cab_5_error": "Gone",
                "data": {
                    "exceptions": {
                        "requested_city_is_no_more_available": true
                    }
                }
            }, null, '\t')
        </script>

        <p class="mt-4">Following response comes if <span class="param">avatar</span> image couldn&apos;t be saved, This happens if server has no more storage or some one messed the server.</p>
        <pre class="response-box"><code class="language-json kill-as-bad-request <?php $this->getUniqueClass() ?>"></code></pre>
        <script>
            document.querySelector('.<?php $this->getUniqueClass(); ?>').innerHTML = JSON.stringify({
                "cab_5_response_code": 506,
                "cab_5_error": "Variant Also Negotiates",
                "data": {
                    "exceptions": {
                        "failed_to_save_avatar": true
                    }
                }
            }, null, '\t')
        </script>

        <p class="mt-4">Following response comes if server has too much load and it couldn&apos;t be able to communicate to database.</p>
        <pre class="response-box"><code class="language-json kill-as-bad-request <?php $this->getUniqueClass() ?>"></code></pre>
        <script>
            document.querySelector('.<?php $this->getUniqueClass(); ?>').innerHTML = JSON.stringify({
                "cab_5_response_code": 506,
                "cab_5_error": "Variant Also Negotiates",
                "data": {
                    "exceptions": {
                        "failed_to_create_driver": true
                    }
                }
            }, null, '\t')
        </script>

        <p class="mt-4">Following response comes if driver already exist with the phone number provided.</p>
        <pre class="response-box"><code class="language-json kill-as-bad-request <?php $this->getUniqueClass() ?>"></code></pre>
        <script>
            document.querySelector('.<?php $this->getUniqueClass(); ?>').innerHTML = JSON.stringify({
                "cab_5_response_code": 506,
                "cab_5_error": "Variant Also Negotiates",
                "data": {
                    "exceptions": {
                        "driver_already_registered": true
                    }
                }
            }, null, '\t')
        </script>

        <p class="mt-4">Following response comes if everything was successful. This <span class="param">authorization_token</span> is important for some request so it should be saved locally.</p>
        <pre class="response-box"><code class="language-json kill-as-bad-request <?php $this->getUniqueClass() ?>"></code></pre>
        <script>
            document.querySelector('.<?php $this->getUniqueClass(); ?>').innerHTML = JSON.stringify({
                "cab_5_response_code": 200,
                "cab_5_error": "NONE",
                "authorization_token": {
                    "abracadabra": "47de06ebd186765d2680c0b92ef473",
                    "token": "xeHweo+le765KXjTVl3ehg==.UXd4b1NqRHBxWGxvYzdlcDlNYjhTVUJuUVlRdVlMZkJLR2JHd..."
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
                        "token": "cac8861ebc1f2fc20fa252b4d1bc0fcf0439137b62fa50d1dc1f1f2d25cac6a32b..."
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
                    }
                }
            }, null, '\t')
        </script>
    <?php }
}