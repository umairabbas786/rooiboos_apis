<?php


class FetchRideCategoriesApiDoc extends ApiDoc {

    function onGeneralMeta() { ?>
        <div class="api-general-meta">
            <h2 class="api-title mt-5">Fetch Ride Categories</h2>
            <div class="api-meta">
                <p class="api-method">POST</p>
                <p class="end-point">fetch_ride_categories.php</p>
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
                <td rowspan="3" class="gravity-center">which_ones</td>
                <td rowspan="3" class="gravity-center">String</td>
                <td rowspan="3" class="gravity-center">True</td>
                <td>ALL</td>
                <td>Returns All Ride Categories</td>
            </tr>
            <tr>
                <td>ENABLED</td>
                <td>Returns All Enabled Ride Categories</td>
            </tr>
            <tr>
                <td>DISABLED</td>
                <td>Returns All Disabled Ride Categories</td>
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

        <p class="mt-4">Successful response sample for Ride Categories.</p>
        <pre class="response-box"><code class="language-json <?php $this->getUniqueClass() ?>"></code></pre>
        <script>
            document.querySelector('.<?php $this->getUniqueClass(); ?>').innerHTML = JSON.stringify({
                "cab_5_response_code": 200,
                "cab_5_error": "NONE",
                "data": {
                    "categories": [
                        {
                            "id": 1,
                            "name": "Business",
                            "enabled": true,
                            "image": "http://192.168.43.175/data/images/ride_categories/162936902558425.jpg",
                            "created_at": "2021-08-19 15:30:25",
                            "updated_at": "2021-08-19 15:30:25"
                        },
                        {
                            "id": 2,
                            "name": "Economy",
                            "enabled": false,
                            "image": "http://192.168.43.175/data/images/ride_categories/162937027583321.jpg",
                            "created_at": "2021-08-19 15:51:15",
                            "updated_at": "2021-08-19 15:51:15"
                        }
                    ]
                }
            }, null, '\t')
        </script>

    <?php }

}