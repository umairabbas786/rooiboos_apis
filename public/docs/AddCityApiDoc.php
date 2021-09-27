<?php


class AddCityApiDoc extends ApiDoc {

    function onGeneralMeta() { ?>
        <div class="api-general-meta">
            <h2 class="api-title mt-5">Add City</h2>
            <div class="api-meta">
                <p class="api-method">POST</p>
                <p class="end-point">add_city.php</p>
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
                <td class="gravity-center">city_name</td>
                <td class="gravity-center">String</td>
                <td class="gravity-center">True</td>
                <td> ----------- </td>
                <td>Name of city to be added</td>
            </tr>
            <tr>
                <td rowspan="2" class="gravity-center">enabled</td>
                <td rowspan="2" class="gravity-center">String</td>
                <td rowspan="2" class="gravity-center">True</td>
                <td>Y</td>
                <td>Saves City as Enabled</td>
            </tr>
            <tr>
                <td>N</td>
                <td>Saves City as Disabled</td>
            </tr>
        </table>
    <?php }

    function onResponseDoc() { ?>
        <p class="mt-4">Following response comes if you forget to pass a parameter, or if the value of parameter is invalid.</p>
        <pre class="response-box"><code class="language-json kill-as-bad-request <?php $this->getUniqueClass() ?>"></code></pre>
        <script>
            document.querySelector('.<?php $this->getUniqueClass(); ?>').innerHTML = JSON.stringify({
                "cab_5_response_code": 400,
                "cab_5_error": "BAD_REQUEST"
            }, null, '\t')
        </script>

        <p class="mt-4">Following response comes if city couldn&apos;t be added due to some database error. This happens when server has lot of load.</p>
        <pre class="response-box"><code class="language-json kill-as-bad-request <?php $this->getUniqueClass() ?>"></code></pre>
        <script>
            document.querySelector('.<?php $this->getUniqueClass(); ?>').innerHTML = JSON.stringify({
                "cab_5_response_code": 506,
                "cab_5_error": "Variant Also Negotiates",
                "data": {
                    "exceptions": {
                        "failed_to_create_city": true
                    }
                }
            }, null, '\t')
        </script>

        <p class="mt-4">Following response comes if city already exists.</p>
        <pre class="response-box"><code class="language-json kill-as-bad-request <?php $this->getUniqueClass() ?>"></code></pre>
        <script>
            document.querySelector('.<?php $this->getUniqueClass(); ?>').innerHTML = JSON.stringify({
                "cab_5_response_code": 506,
                "cab_5_error": "Variant Also Negotiates",
                "data": {
                    "exceptions": {
                        "city_already_exist": true
                    }
                }
            }, null, '\t')
        </script>

        <p class="mt-4">Following response comes if city is added successfully.</p>
        <pre class="response-box"><code class="language-json kill-as-bad-request <?php $this->getUniqueClass() ?>"></code></pre>
        <script>
            document.querySelector('.<?php $this->getUniqueClass(); ?>').innerHTML = JSON.stringify({
                "cab_5_response_code": 200,
                "cab_5_error": "NONE",
                "data": {
                    "city": {
                        "id": 1,
                        "name": "Miani",
                        "enabled": true,
                        "created_at": "2021-08-19 13:24:03",
                        "updated_at": "2021-08-19 13:24:03"
                    }
                }
            }, null, '\t')
        </script>
    <?php }
}