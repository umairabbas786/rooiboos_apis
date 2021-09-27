<?php


class LoginAsClientApiDoc extends ApiDoc {

    function onGeneralMeta() { ?>
        <div class="api-general-meta">
            <h2 class="api-title mt-5">Login As Client</h2>
            <div class="api-meta">
                <p class="api-method">POST</p>
                <p class="end-point">login_as_client.php</p>
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

        <p class="mt-4">Following response comes if client is not found.</p>
        <pre class="response-box"><code class="language-json <?php $this->getUniqueClass() ?>"></code></pre>
        <script>
            document.querySelector('.<?php $this->getUniqueClass(); ?>').innerHTML = JSON.stringify({
                "cab_5_response_code": 200,
                "cab_5_error": "NONE",
                "data": {
                    "user": null
                }
            }, null, '\t')
        </script>

        <p class="mt-4">Following response comes if client is found successfully!</p>
        <pre class="response-box"><code class="language-json <?php $this->getUniqueClass() ?>"></code></pre>
        <script>
            document.querySelector('.<?php $this->getUniqueClass(); ?>').innerHTML = JSON.stringify({
                "cab_5_response_code": 200,
                "cab_5_error": "NONE",
                "authorization_token": {
                    "abracadabra": "c112a432df647b503f44b0e0008df2",
                    "token": "RVPNmfUhWN01zFgcNdJuhg==.T3hSWEowc21IRkZVc2tnekhqL0xFVENuM1..."
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
                        "token": "ac9417d56c39f66cb9b48c794403d7c201b91a555433357d7d29a59..."
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