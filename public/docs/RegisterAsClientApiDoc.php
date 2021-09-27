<?php


class RegisterAsClientApiDoc extends ApiDoc {

    function onGeneralMeta() { ?>
        <div class="api-general-meta">
            <h2 class="api-title mt-5">Register As Client</h2>
            <div class="api-meta">
                <p class="api-method">POST</p>
                <p class="end-point">register_as_client.php</p>
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
                <td>Phone no. of Client</td>
            </tr>
            <tr>
                <td>first_name</td>
                <td>String</td>
                <td>True</td>
                <td> --------- </td>
                <td>First Name of Client</td>
            </tr>
            <tr>
                <td>last_name</td>
                <td>String</td>
                <td>True</td>
                <td> --------- </td>
                <td>Last Name of Client</td>
            </tr>
            <tr>
                <td>email</td>
                <td>String</td>
                <td>True</td>
                <td> --------- </td>
                <td>Email of Client</td>
            </tr>
            <tr>
                <td>avatar</td>
                <td>Multipart</td>
                <td>True</td>
                <td> --------- </td>
                <td>Avatar of Client</td>
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
                        "failed_to_create_client": true
                    }
                }
            }, null, '\t')
        </script>

        <p class="mt-4">Following response comes if client is already registered.</p>
        <pre class="response-box"><code class="language-json kill-as-bad-request <?php $this->getUniqueClass() ?>"></code></pre>
        <script>
            document.querySelector('.<?php $this->getUniqueClass(); ?>').innerHTML = JSON.stringify({
                "cab_5_response_code": 506,
                "cab_5_error": "Variant Also Negotiates",
                "data": {
                    "exceptions": {
                        "client_already_registered": true
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
                    "abracadabra": "9a0ec906cf8d70147aa3a54a482a4f",
                    "token": "fUFs7XE/dYk+cf3RqhGtdg==.QUhwSW1HOXRmQndZREx6bzljNFQ0Y2QxeEt5V..."
                },
                "data": {
                    "user": {
                        "id": 2,
                        "first_name": "Attaullah",
                        "last_name": "Khan",
                        "username": "",
                        "email": "attaullahkhanlodhi@gmail.com",
                        "password": "",
                        "abracadabra": "",
                        "phone": "+923474350557",
                        "verified_email": false,
                        "verified_phone": true,
                        "created_at": "2021-08-20 15:11:17",
                        "updated_at": "2021-08-20 15:11:17",
                        "role": "CLIENT",
                        "token": "ac9417d56c39f66cb9b48c794403d7c201b91a555433357d7d29a5920a..."
                    },
                    "avatar": {
                        "id": 2,
                        "avatar": "http://192.168.43.175/data/images/avatars/162945427739692.jpg",
                        "created_at": "2021-08-20 15:11:17",
                        "updated_at": "2021-08-20 15:11:17"
                    }
                }
            }, null, '\t')
        </script>

    <?php }
}