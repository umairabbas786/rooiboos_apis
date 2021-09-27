<?php


class SetRideStateArrivedApiDoc extends ApiDoc {

    function onGeneralMeta() { ?>
        <div class="api-general-meta">
            <h2 class="api-title mt-5">Set Ride State Arrived</h2>
            <div class="api-meta">
                <p class="api-method">POST</p>
                <p class="end-point">set_ride_state_arrived.php</p>
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

        <p class="mt-4">Following response comes if your provided <span class="param">__user_id__</span> is of a client instead of a driver.</p>
        <pre class="response-box"><code class="language-json kill-as-bad-request <?php $this->getUniqueClass() ?>"></code></pre>
        <script>
            document.querySelector('.<?php $this->getUniqueClass(); ?>').innerHTML = JSON.stringify({
                "cab_5_response_code": 410,
                "cab_5_error": "Gone",
                "data": {
                    "exceptions": {
                        "requested_driver_is_not_available_in_database": true
                    }
                }
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

        <p class="mt-4">Following response comes, if the data couldn&apos;t be updated in db, due to server overload.</p>
        <pre class="response-box"><code class="language-json kill-as-bad-request <?php $this->getUniqueClass() ?>"></code></pre>
        <script>
            document.querySelector('.<?php $this->getUniqueClass(); ?>').innerHTML = JSON.stringify({
                "cab_5_response_code": 506,
                "cab_5_error": "Variant Also Negotiates",
                "data": {
                    "exceptions": {
                        "failed_to_update_state": true
                    }
                }
            }, null, '\t')
        </script>

        <p class="mt-4">Following response comes when state is updated successfully.</p>
        <pre class="response-box"><code class="language-json kill-as-bad-request <?php $this->getUniqueClass() ?>"></code></pre>
        <script>
            document.querySelector('.<?php $this->getUniqueClass(); ?>').innerHTML = JSON.stringify({
                "cab_5_response_code": 200,
                "cab_5_error": "NONE",
                "data": {
                    "updated_to_arrival_state": true
                }
            }, null, '\t')
        </script>

    <?php }
}