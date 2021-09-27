<?php


class AddRideCategoryApiDoc extends ApiDoc {

    function onGeneralMeta() { ?>
        <div class="api-general-meta">
            <h2 class="api-title mt-5">Add Ride Category</h2>
            <div class="api-meta">
                <p class="api-method">POST</p>
                <p class="end-point">add_ride_category.php</p>
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
                <td class="gravity-center">name</td>
                <td class="gravity-center">String</td>
                <td class="gravity-center">True</td>
                <td> ----------- </td>
                <td>Name of Ride Category to be added</td>
            </tr>
            <tr>
                <td rowspan="2" class="gravity-center">enabled</td>
                <td rowspan="2" class="gravity-center">String</td>
                <td rowspan="2" class="gravity-center">True</td>
                <td>Y</td>
                <td>Saves Ride Category as Enabled</td>
            </tr>
            <tr>
                <td>N</td>
                <td>Saves Ride Category as Disabled</td>
            </tr>
            <tr>
                <td class="gravity-center">image</td>
                <td class="gravity-center">Multipart</td>
                <td class="gravity-center">True</td>
                <td> ----------- </td>
                <td>Image for this ride category</td>
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

        <p class="mt-4">Following response comes if ride category already exists.</p>
        <pre class="response-box"><code class="language-json kill-as-bad-request <?php $this->getUniqueClass() ?>"></code></pre>
        <script>
            document.querySelector('.<?php $this->getUniqueClass(); ?>').innerHTML = JSON.stringify({
                "cab_5_response_code": 506,
                "cab_5_error": "Variant Also Negotiates",
                "data": {
                    "exceptions": {
                        "ride_category_already_exist": true
                    }
                }
            }, null, '\t')
        </script>

        <p class="mt-4">Following response comes if ride category image couldn&apos;t be saved. This happens when server has no storage left or some one messed the server.</p>
        <pre class="response-box"><code class="language-json kill-as-bad-request <?php $this->getUniqueClass() ?>"></code></pre>
        <script>
            document.querySelector('.<?php $this->getUniqueClass(); ?>').innerHTML = JSON.stringify({
                "cab_5_response_code": 506,
                "cab_5_error": "Variant Also Negotiates",
                "data": {
                    "exceptions": {
                        "failed_to_save_image": true
                    }
                }
            }, null, '\t')
        </script>

        <p class="mt-4">Following response comes if ride category couldn&apos;t be saved. This happens when server has lot of load.</p>
        <pre class="response-box"><code class="language-json kill-as-bad-request <?php $this->getUniqueClass() ?>"></code></pre>
        <script>
            document.querySelector('.<?php $this->getUniqueClass(); ?>').innerHTML = JSON.stringify({
                "cab_5_response_code": 506,
                "cab_5_error": "Variant Also Negotiates",
                "data": {
                    "exceptions": {
                        "failed_to_create_ride_category": true
                    }
                }
            }, null, '\t')
        </script>

        <p class="mt-4">Following response comes if ride category is added successfully.</p>
        <pre class="response-box"><code class="language-json kill-as-bad-request <?php $this->getUniqueClass() ?>"></code></pre>
        <script>
            document.querySelector('.<?php $this->getUniqueClass(); ?>').innerHTML = JSON.stringify({
                "cab_5_response_code": 200,
                "cab_5_error": "NONE",
                "data": {
                    "ride_category": {
                        "id": 1,
                        "name": "Business",
                        "enabled": true,
                        "image": "http://192.168.43.175/data/images/ride_categories/162936902558425.jpg",
                        "created_at": "2021-08-19 15:30:25",
                        "updated_at": "2021-08-19 15:30:25"
                    }
                }
            }, null, '\t')
        </script>
    <?php }
}