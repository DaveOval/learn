<?php
echo'
<html>
    <head>
        <title>Learn to fly</title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    </head>
    <body>
        <div id="login">
            <div class="container mt-5">
                <div class="row justify-content-center">
                    <div class="col-md-6">
                        <div class="card">
                            <div class="card-header text-center">
                                <h3>Login</h3>
                            </div>
                            <div class="card-body">
                                <form onsubmit="event.preventDefault(); login();" >
                                <div class="form-group">
                                    <label for="user">Usuario</label>
                                    <input type="user" class="form-control" id="user" placeholder="Usuario">
                                </div>
                                <div class="form-group">
                                    <label for="password">Password</label>
                                    <input type="password" class="form-control" id="password" placeholder="Password">
                                </div>
                                <button type="submit" class="btn btn-primary btn-block mt-3">Login</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <div id="result"></div>
        <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
        <script src="js/events.js"></script> 
        <script src="https://www.paypal.com/sdk/js?client-id=AbNIMl1p1ehS_e_Tv7Ozvw_oQjAFAC-JuPiK-foXIlwLXlgmHE13atymtvQybJrmlYiey77AJMJ_44ob&currency=MXN"></script>
        <script src="app.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    </body>
</html>
';
?>