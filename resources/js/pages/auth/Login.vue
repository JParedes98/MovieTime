<template>
<div>
    <navbar></navbar>

    <div class="container pt-5 mt-5">
        <div class="row justify-content-center">
            <div class="col-md-4 col-sm-12 card card-body shadow">
                <div class="form-group">
                    <img src="/logo.png" style="max-width: 120px;" class="d-block m-auto" alt="">
                    <h2 class="font-weight-bold text-center text-muted my-4">¡WELCOME BACK!</h2>
                </div>

                <div class="form-group">
                    <label class="font-weight-bold text-muted" for="email"><i class="fas fa-envelope-open-text"></i>&nbsp;Email</label>
                    <input type="email" class="form-control" placeholder="user@movietime.com">
                </div>

                <div class="form-group">
                    <label class="font-weight-bold text-muted" for="password"><i class="fas fa-unlock-alt"></i>&nbsp;Password</label>
                    <input type="password" class="form-control" placeholder="Type your password">
                </div>

                <div class="form-group my-3">
                    <p class="text-muted text-center">Don't you have an account yet? <router-link to="register" tag="a">Sign Up</router-link> </p>
                </div>

                <div class="form-group my-4">
                    <input type="submit" class="btn btn-block btn-primary" value="SIGN IN">
                </div>
            </div>
        </div>
    </div>
</div>
</template>

<script>
export default {
    data: function () {
        return {

        };
    },

    created() {

    },

    methods: {

    }
}
</script>
