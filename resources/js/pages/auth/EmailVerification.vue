<template>
<div>
    <navbar></navbar>

    <div class="container pt-5 mt-5">
        <div class="row justify-content-center">
            <div class="col-md-4 col-sm-12 card card-body shadow">
                <form @submit.prevent="EmailVerification">
                    <div class="form-group">
                        <img src="/logo.png" style="max-width: 120px;" class="d-block m-auto" alt="">
                        <h2 class="font-weight-bold text-center text-muted my-4">¡<span class="text-primary">EMAIL</span> VERIFICATION!</h2>

                        <br>

                        <p class="text-muted text-center" style="font-size: 18px;">Please click the button "VERIFY" to confirm your account.</p>
                    </div>

                    <div class="form-group">
                        <b-alert v-if="verified" class="text-center my-4" variant="primary" show dismissible>
                            Account verified succesffully.
                        </b-alert>
                    </div>

                    <div class="form-group my-5">
                        <input type="submit" class="btn btn-block btn-primary" value="VERIFY">
                    </div>

                    <div class="form-group my-4">
                        <router-link to="/login" tag="button" class="btn btn-block btn-secondary">
                            GO BACK
                        </router-link>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
</template>

<script>
export default {
    data: function () {
        return {
            password: '',
            repeat: '',
            verified: false
        };
    },

    methods: {
        async EmailVerification() {
            var token = this.$route.params.token;

            const config = {
                headers: { Authorization: `Bearer ${token}` }
            };

            axios.post('/api/v1/auth/email-verification',null, config)
                .then((res) => {
                    Vue.swal({
                        icon: 'success',
                        title: '¡Great!',
                        text: 'Account verified succesfully.',
                        showConfirmButton: false,
                        timer: 1500,
                        timerProgressBar: true,
                    });
                    localStorage.removeItem('mt_user');
                    localStorage.setItem('mt_user', JSON.stringify(res.data));
                    localStorage.setItem('mt_token', this.$route.params.token);
                    this.$router.push('/');
                })
                .catch(function (error) {
                    console.log(error);
                    Vue.swal({
                        toast: true,
                        icon: 'error',
                        title: '¡Ups!',
                        text: 'Authentication Error.',
                        position: 'bottom-end',
                        showConfirmButton: false,
                        timer: 3000,
                        timerProgressBar: true,
                    });
                });
        }
    }
}
</script>
