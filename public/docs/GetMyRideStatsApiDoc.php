<?php


class GetMyRideStatsApiDoc extends ApiDoc {

    function onGeneralMeta() { ?>
        <div class="api-general-meta">
            <h2 class="api-title mt-5">Get My Ride Stats</h2>
            <div class="api-meta">
                <p class="api-method">POST</p>
                <p class="end-point">get_my_ride_stats.php</p>
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
                <td>ID of client/driver</td>
            </tr>
            <tr>
                <td class="gravity-center">__authorization_token__</td>
                <td class="gravity-center">String</td>
                <td class="gravity-center">True</td>
                <td> ----------- </td>
                <td>Authorization token of client/Driver</td>
            </tr>
            <tr>
                <td class="gravity-center">__abracadabra__</td>
                <td class="gravity-center">String</td>
                <td class="gravity-center">True</td>
                <td> ----------- </td>
                <td>Abracadabra which was provided with Authorization Token.</td>
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

        <p class="mt-4">Following response comes if any parameter is missing or a given parameter value is wrong.</p>
        <pre class="response-box"><code class="language-json kill-as-bad-request <?php $this->getUniqueClass() ?>"></code></pre>
        <script>
            document.querySelector('.<?php $this->getUniqueClass(); ?>').innerHTML = JSON.stringify({
                "cab_5_response_code": 400,
                "cab_5_error": "BAD_REQUEST"
            }, null, '\t')
        </script>

        <p class="mt-4">Following response comes if no ride is found.</p>
        <pre class="response-box"><code class="language-json kill-as-bad-request <?php $this->getUniqueClass() ?>"></code></pre>
        <script>
            document.querySelector('.<?php $this->getUniqueClass(); ?>').innerHTML = JSON.stringify({
                "cab_5_response_code": 506,
                "cab_5_error": "Variant Also Negotiates",
                "data": {
                    "exceptions": {
                        "no_ride_found": true
                    }
                }
            }, null, '\t')
        </script>

        <p class="mt-4">Following response comes if ride was found, but unfortunately the driver doesn&apos;t exist in database.</p>
        <pre class="response-box"><code class="language-json kill-as-bad-request <?php $this->getUniqueClass() ?>"></code></pre>
        <script>
            document.querySelector('.<?php $this->getUniqueClass(); ?>').innerHTML = JSON.stringify({
                "cab_5_response_code": 506,
                "cab_5_error": "Variant Also Negotiates",
                "data": {
                    "exceptions": {
                        "no_driver_found": true
                    }
                }
            }, null, '\t')
        </script>

        <p class="mt-4">Following response comes for client account, when response is successful. meters travelled will be <span class="param">NULL</span> until driver has not arrived to user,
            and user has not sat in the ride. Once both are in car, make a request to update driver distance api, which will add the distance hence will be non-null.</p>
        <pre class="response-box"><code class="language-json kill-as-bad-request <?php $this->getUniqueClass() ?>"></code></pre>
        <script>
            document.querySelector('.<?php $this->getUniqueClass(); ?>').innerHTML = JSON.stringify({
                "cab_5_response_code": 200,
                "cab_5_error": "NONE",
                "data": {
                    "ride_meta": {
                        "id": 1,
                        "user_id": 2,
                        "pickup_lng": 72.12323123,
                        "pickup_lat": 32.12131111,
                        "state": "ACCEPTED_BY_DRIVER",
                        "meters_travelled": null,
                        "created_at": "2021-08-19 16:40:18",
                        "updated_at": "2021-08-19 16:40:18"
                    },
                    "driver_meta": {
                        "id": 1,
                        "lng": 71.12323123,
                        "lat": 31.12131111,
                        "avatar": "http://192.168.43.175/data/images/avatars/16293732187711.jpg",
                    }
                }
            }, null, '\t')
        </script>

        <p class="mt-4">Following response comes for driver account, when response is successful. meters travelled will be <span class="param">NULL</span> until driver has not arrived to user,
            and user has not sat in the ride. Once both are in car, make a request to update driver distance api, which will add the distance hence will be non-null.</p>
        <pre class="response-box"><code class="language-json kill-as-bad-request <?php $this->getUniqueClass() ?>"></code></pre>
        <script>
            document.querySelector('.<?php $this->getUniqueClass(); ?>').innerHTML = JSON.stringify({
                "cab_5_response_code": 200,
                "cab_5_error": "NONE",
                "data": {
                    "ride_meta": {
                        "id": 1,
                        "user_id": 2,
                        "pickup_lng": 72.12323123,
                        "pickup_lat": 32.12131111,
                        "state": "ACCEPTED_BY_DRIVER",
                        "meters_travelled": null,
                        "created_at": "2021-08-19 16:40:18",
                        "updated_at": "2021-08-19 16:40:18"
                    }
                }
            }, null, '\t')
        </script>
    <?php }
}
