<?php


class CancelCurrentRideApiDoc extends ApiDoc {

    function onGeneralMeta() { ?>
        <div class="api-general-meta">
            <h2 class="api-title mt-5">Cancel Current Ride</h2>
            <div class="api-meta">
                <p class="api-method">POST</p>
                <p class="end-point">cancel_current_ride.php</p>
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
                <td>ID of Client</td>
            </tr>
            <tr>
                <td class="gravity-center">__authorization_token__</td>
                <td class="gravity-center">String</td>
                <td class="gravity-center">True</td>
                <td> ----------- </td>
                <td>Authorization token of Client</td>
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

        <p class="mt-4">Following response comes if your provided <span class="param">__user_id__</span> is of a driver instead of a client.</p>
        <pre class="response-box"><code class="language-json kill-as-bad-request <?php $this->getUniqueClass() ?>"></code></pre>
        <script>
            document.querySelector('.<?php $this->getUniqueClass(); ?>').innerHTML = JSON.stringify({
                "cab_5_response_code": 410,
                "cab_5_error": "Gone",
                "data": {
                    "exceptions": {
                        "requested_client_is_not_available_in_database": true
                    }
                }
            }, null, '\t')
        </script>

        <p class="mt-4">Following response comes if data could not be updated in database, This happens if server has too much load.</p>
        <pre class="response-box"><code class="language-json kill-as-bad-request <?php $this->getUniqueClass() ?>"></code></pre>
        <script>
            document.querySelector('.<?php $this->getUniqueClass(); ?>').innerHTML = JSON.stringify({
                "cab_5_response_code": 506,
                "cab_5_error": "Variant Also Negotiates",
                "data": {
                    "exceptions": {
                        "failed_to_cancel_ride": true
                    }
                }
            }, null, '\t')
        </script>

        <p class="mt-4">Following response comes when response is successful. <span class="param">ride_cancelled</span> this will be <span class="param">true</span>
            always if ride was cancelled. <span class="param">ride_cancel_notification_sent</span> This will be
            <span class="param">null</span> if ride wasn&apos;t accepted by any driver yet
            and user has cancelled the ride else it depends on response from Firebase Services if they sent it then this will
            be <span class="param">true</span> else <span class="param">false</span>
        </p>
        <pre class="response-box"><code class="language-json kill-as-bad-request <?php $this->getUniqueClass() ?>"></code></pre>
        <script>
            document.querySelector('.<?php $this->getUniqueClass(); ?>').innerHTML = JSON.stringify({
                "cab_5_response_code": 200,
                "cab_5_error": "NONE",
                "data": {
                    "ride_cancelled": true,
                    "ride_cancel_notification_sent": null
                }
            }, null, '\t')
        </script>

    <?php }
}