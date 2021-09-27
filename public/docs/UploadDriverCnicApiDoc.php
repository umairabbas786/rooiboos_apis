<?php


class UploadDriverCnicApiDoc extends ApiDoc {

    function onGeneralMeta() { ?>
        <div class="api-general-meta">
            <h2 class="api-title mt-5">Upload Driver CNIC</h2>
            <div class="api-meta">
                <p class="api-method">POST</p>
                <p class="end-point">upload_driver_cnic.php</p>
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
                <td class="gravity-center">__user_id__</td>
                <td class="gravity-center">String</td>
                <td class="gravity-center">True</td>
                <td> ----------- </td>
                <td>ID of driver</td>
            </tr>
            <tr>
                <td class="gravity-center">__authorization_token__</td>
                <td class="gravity-center">String</td>
                <td class="gravity-center">True</td>
                <td> ----------- </td>
                <td>Authorization token of Driver</td>
            </tr>
            <tr>
                <td class="gravity-center">__abracadabra__</td>
                <td class="gravity-center">String</td>
                <td class="gravity-center">True</td>
                <td> ----------- </td>
                <td>Abracadabra which was provided with Authorization Token.</td>
            </tr>
            <tr>
                <td class="gravity-center">cnic_front</td>
                <td class="gravity-center">Multipart</td>
                <td class="gravity-center">True</td>
                <td> ----------- </td>
                <td>Front Image of CNIC</td>
            </tr>
            <tr>
                <td class="gravity-center">cnic_back</td>
                <td class="gravity-center">Multipart</td>
                <td class="gravity-center">True</td>
                <td> ----------- </td>
                <td>Backside image of CNIC</td>
            </tr>
        </table>
    <?php }

    function onResponseDoc() { ?>
        <p class="mt-4">Following response comes if you provided <span class="param">__user_id__</span>, but the server couldn&apos;t find any user with that id.</p>
        <pre class="response-box"><code class="language-json <?php $this->getUniqueClass() ?>"></code></pre>
        <script>
            document.querySelector('.<?php $this->getUniqueClass(); ?>').innerHTML = JSON.stringify({
                "cab_5_response_code": 410,
                "cab_5_error": "Gone",
                "data": {
                    "exceptions": {
                        "user_unavailable": true
                    }
                }
            }, null, '\t')
        </script>

        <p class="mt-4">Following response comes if token is not valid.</p>
        <pre class="response-box"><code class="language-json <?php $this->getUniqueClass() ?>"></code></pre>
        <script>
            document.querySelector('.<?php $this->getUniqueClass(); ?>').innerHTML = JSON.stringify({
                "cab_5_response_code": 403,
                "cab_5_error": "UNAUTHORIZED"
            }, null, '\t')
        </script>

        <p class="mt-4">Following response comes if any given parameter name is wrong.</p>
        <pre class="response-box"><code class="language-json kill-as-bad-request <?php $this->getUniqueClass() ?>"></code></pre>
        <script>
            document.querySelector('.<?php $this->getUniqueClass(); ?>').innerHTML = JSON.stringify({
                "cab_5_response_code": 400,
                "cab_5_error": "BAD_REQUEST"
            }, null, '\t')
        </script>

        <p class="mt-4">Following response comes if Driver CNIC is already Uploaded.</p>
        <pre class="response-box"><code class="language-json kill-as-bad-request <?php $this->getUniqueClass() ?>"></code></pre>
        <script>
            document.querySelector('.<?php $this->getUniqueClass(); ?>').innerHTML = JSON.stringify({
                "cab_5_response_code": 506,
                "cab_5_error": "Variant Also Negotiates",
                "data": {
                    "exceptions": {
                        "driver_cnic_already_exist": true
                    }
                }
            }, null, '\t')
        </script>

        <p class="mt-4">Following response comes if cnic images couldn&apos;t be saved. This happens due to server low storage or if someone messed with the server.</p>
        <pre class="response-box"><code class="language-json kill-as-bad-request <?php $this->getUniqueClass() ?>"></code></pre>
        <script>
            document.querySelector('.<?php $this->getUniqueClass(); ?>').innerHTML = JSON.stringify({
                "cab_5_response_code": 506,
                "cab_5_error": "Variant Also Negotiates",
                "data": {
                    "exceptions": {
                        "failed_to_save_cnic_images": true
                    }
                }
            }, null, '\t')
        </script>

        <p class="mt-4">Following response comes if record is not added. This happens if server has too much load.</p>
        <pre class="response-box"><code class="language-json kill-as-bad-request <?php $this->getUniqueClass() ?>"></code></pre>
        <script>
            document.querySelector('.<?php $this->getUniqueClass(); ?>').innerHTML = JSON.stringify({
                "cab_5_response_code": 506,
                "cab_5_error": "Variant Also Negotiates",
                "data": {
                    "exceptions": {
                        "failed_to_upload_driver_cnic": true
                    }
                }
            }, null, '\t')
        </script>

        <p class="mt-4">Following response comes if CNIC is uploaded successfully.</p>
        <pre class="response-box"><code class="language-json kill-as-bad-request <?php $this->getUniqueClass() ?>"></code></pre>
        <script>
            document.querySelector('.<?php $this->getUniqueClass(); ?>').innerHTML = JSON.stringify({
                "cab_5_response_code": 200,
                "cab_5_error": "NONE",
                "data": {
                    "cnic": {
                        "id": 1,
                        "user_id": 1,
                        "cnic_front": "http://192.168.43.175/data/images/driver_cnic/162937957518595.jpg",
                        "cnic_back": "http://192.168.43.175/data/images/driver_cnic/16293795754907.jpg",
                        "created_at": "2021-08-19 18:26:15",
                        "updated_at": "2021-08-19 18:26:15"
                    }
                }
            }, null, '\t')
        </script>
    <?php }
}