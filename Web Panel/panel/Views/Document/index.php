<style>
    .pc-collapse {
        font-size: 11px;
        border-radius: 4px;
        padding: 2px 8px;
        background: #68c0ff;
        color: #fff;
        z-index: 1;
    }
</style>
<!-- [ Main Content ] start -->
<div class="pc-container">
    <div class="pc-content">
        <!-- [ breadcrumb ] start -->
        <div class="page-header">
            <div class="page-block">
                <div class="row align-items-center">
                    <div class="col-md-12">
                        <div class="page-header-title">
                            <h2 class="mb-0">Documents API</h2>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- [ breadcrumb ] end -->


        <!-- [ Main Content ] start -->
        <div class="row">

            <div class="col-12">
                <div class="accordion card" id="accordionExample">

                    <div class="accordion-item">
                        <h2 class="accordion-header" id="headingOne">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="false" aria-controls="collapseOne">
                                All User
                            </button>
                        </h2>
                        <div id="collapseOne" class="accordion-collapse collapse" aria-labelledby="headingOne" data-bs-parent="#accordionExample">
                            <div class="accordion-body" dir="ltr">
                                <a href="<?php echo path;?>Settings&sort=api" target="_blank">List API</a><br>
                                {APIKEY}=Token<br>
                                <span class="pc-collapse">Method GET</span><br>
                                <code><?php echo path;?>api&key={APIKEY}&method=listuser</code><br>
                                Result
                                <div class="p-3 color-block bg-gray-200">
                                    <code>
                                        {<br>
                                        "status": 200,<br>
                                        "data": [<br>
                                        {<br>
                                        "id": "1",<br>
                                        "username": "tetuser",<br>
                                        "password": "1010",<br>
                                        "email": "test@gmail.com",<br>
                                        "mobile": "09120000000",<br>
                                        "multiuser": "1",<br>
                                        "startdate": "2023-06-04",<br>
                                        "finishdate": "2023-07-04",<br>
                                        "finishdate_one_connect": "30",<br>
                                        "enable": "true",<br>
                                        "traffic": "0",<br>
                                        "referral": "",<br>
                                        "info": ""<br>
                                        },<br>
                                        {<br>
                                        "id": "2",<br>
                                        "username": "tetuser2",<br>
                                        "password": "2020",<br>
                                        "email": "test@gmail.com",<br>
                                        "mobile": "09120000000",<br>
                                        "multiuser": "1",<br>
                                        "startdate": "2023-06-04",<br>
                                        "finishdate": "2023-07-04",<br>
                                        "finishdate_one_connect": "30",<br>
                                        "enable": "true",<br>
                                        "traffic": "0",<br>
                                        "referral": "",<br>
                                        "info": ""<br>
                                        }<br>
                                        ]<br>
                                        }
                                    </code>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="accordion-item">
                        <h2 class="accordion-header" id="headingTwo">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                                Sort Users Status
                            </button>
                        </h2>
                        <div id="collapseTwo" class="accordion-collapse collapse" aria-labelledby="headingTwo" data-bs-parent="#accordionExample">
                            <div class="accordion-body" dir="ltr">
                                <a href="<?php echo path;?>Settings&sort=api" target="_blank">List API</a><br>
                                {APIKEY}=Token<br>
                                {STATUS}=true<br>
                                <div class="p-3 color-block bg-green-100">
                                    <code>
                                        <b style="color:green">true</b> Active user <br>
                                        <b style="color:green">false</b> DeActive user <br>
                                        <b style="color:green">expired</b> Expired Date user <br>
                                        <b style="color:green">traffic</b> Conduct traffic user
                                    </code></div>
                                <span class="pc-collapse">Method GET</span><br>
                                <code><?php echo path;?>api&key={APIKEY}&method=users&status={STATUS}</code><br>
                                Result
                                <div class="p-3 color-block bg-gray-200">
                                    <code>
                                        {<br>
                                        "status": 200,<br>
                                        "data": [<br>
                                        {<br>
                                        "id": "1",<br>
                                        "username": "tetuser",<br>
                                        "password": "1010",<br>
                                        "email": "test@gmail.com",<br>
                                        "mobile": "09120000000",<br>
                                        "multiuser": "1",<br>
                                        "startdate": "2023-06-04",<br>
                                        "finishdate": "2023-07-04",<br>
                                        "finishdate_one_connect": "30",<br>
                                        "enable": "true",<br>
                                        "traffic": "0",<br>
                                        "referral": "",<br>
                                        "info": ""<br>
                                        },<br>
                                        {<br>
                                        "id": "2",<br>
                                        "username": "tetuser2",<br>
                                        "password": "2020",<br>
                                        "email": "test@gmail.com",<br>
                                        "mobile": "09120000000",<br>
                                        "multiuser": "1",<br>
                                        "startdate": "2023-06-04",<br>
                                        "finishdate": "2023-07-04",<br>
                                        "finishdate_one_connect": "30",<br>
                                        "enable": "true",<br>
                                        "traffic": "0",<br>
                                        "referral": "",<br>
                                        "info": ""<br>
                                        }<br>
                                        ]<br>
                                        }
                                    </code>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="accordion-item">
                        <h2 class="accordion-header" id="headingThree">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
                                Add user
                            </button>
                        </h2>
                        <div id="collapseThree" class="accordion-collapse collapse" aria-labelledby="headingThree" data-bs-parent="#accordionExample">
                            <div class="accordion-body" dir="ltr">
                                <a href="<?php echo path;?>Settings&sort=api" target="_blank">List API</a><br>
                                {APIKEY}=Token<br>
                                <span class="pc-collapse">Method POST</span><br>
                                <code><?php echo path;?>api&key={APIKEY}&method=adduser</code><br>
                                Send Data Post
                                <div class="p-3 color-block bg-green-100">
                                    <code>
                                        <b>username</b> Required<br>
                                        <b>password</b> Required<br>
                                        <b>email</b> String<br>
                                        <b>mobile</b> String<br>
                                        <b>multiuser</b> Required<br>
                                        <b>traffic</b> Required<br>
                                        <b>type_traffic</b> Required(gb or mb)<br>
                                        <b>expdate</b> Required(format 2023-07-04)<br>
                                        <b>connection_start</b> String<br>
                                        <small>If you want to set the expdate on the first connection, enter the number of validity days in the field above</small><br>
                                        <b>desc</b> String<br>
                                    </code>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="accordion-item">
                        <h2 class="accordion-header" id="headingFour">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseFour" aria-expanded="false" aria-controls="collapseFour">
                                Delete user
                            </button>
                        </h2>
                        <div id="collapseFour" class="accordion-collapse collapse" aria-labelledby="headingFour" data-bs-parent="#accordionExample">
                            <div class="accordion-body" dir="ltr">
                                <a href="<?php echo path;?>Settings&sort=api" target="_blank">List API</a><br>
                                {APIKEY}=Token<br>
                                <span class="pc-collapse">Method POST</span><br>
                                <code><?php echo path;?>api&key={APIKEY}method=deleteuser</code><br>
                                Send Data Post
                                <div class="p-3 color-block bg-green-100">
                                    <code>
                                        <b>username</b> Required<br>
                                    </code>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="accordion-item">
                        <h2 class="accordion-header" id="headingFive">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseFive" aria-expanded="false" aria-controls="collapseFive">
                                Show Detail user
                            </button>
                        </h2>
                        <div id="collapseFive" class="accordion-collapse collapse" aria-labelledby="headingFive" data-bs-parent="#accordionExample">
                            <div class="accordion-body" dir="ltr">
                                <a href="<?php echo path;?>Settings&sort=api" target="_blank">List API</a><br>
                                {APIKEY}=Token<br>
                                <span class="pc-collapse">Method GET</span><br>
                                <code><?php echo path;?>api&key={APIKEY}method=user&username={USERNAME}</code><br>
                                Send Data Get
                                <div class="p-3 color-block bg-green-100">
                                    <code>
                                        <b>username</b> Required<br>
                                    </code>
                                </div>
                                Result
                                <div class="p-3 color-block bg-gray-200">
                                    <code>
                                        {<br>
                                        "status": 200,<br>
                                        "data": [<br>
                                        {<br>
                                        "id": "1",<br>
                                        "username": "tetuser",<br>
                                        "password": "1010",<br>
                                        "email": "test@gmail.com",<br>
                                        "mobile": "09120000000",<br>
                                        "multiuser": "1",<br>
                                        "startdate": "2023-06-04",<br>
                                        "finishdate": "2023-07-04",<br>
                                        "finishdate_one_connect": "30",<br>
                                        "enable": "true",<br>
                                        "traffic": "0",<br>
                                        "referral": "",<br>
                                        "info": ""<br>
                                        }<br>
                                        ]<br>
                                        }
                                    </code>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="accordion-item">
                        <h2 class="accordion-header" id="headingSix">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseSix" aria-expanded="false" aria-controls="collapseSix">
                                Edit user
                            </button>
                        </h2>
                        <div id="collapseSix" class="accordion-collapse collapse" aria-labelledby="headingSix" data-bs-parent="#accordionExample">
                            <div class="accordion-body" dir="ltr">
                                <a href="<?php echo path;?>Settings&sort=api" target="_blank">List API</a><br>
                                {APIKEY}=Token<br>
                                <span class="pc-collapse">Method POST</span><br>
                                <code><?php echo path;?>api&key={APIKEY}method=edituser</code><br>
                                Send Data Post
                                <div class="p-3 color-block bg-green-100">
                                    <code>
                                        <b>username</b> Required<br>
                                        <b>password</b> Required<br>
                                        <b>email</b> String<br>
                                        <b>mobile</b> String<br>
                                        <b>multiuser</b> Required<br>
                                        <b>traffic</b> Required<br>
                                        <b>type_traffic</b> Required(gb or mb)<br>
                                        <b>expdate</b> Required(format 2023-07-04)<br>
                                        <b>desc</b> String<br>
                                    </code>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
        <!-- [ Main Content ] end -->
    </div>
</div>
<!-- [ Main Content ] end -->
