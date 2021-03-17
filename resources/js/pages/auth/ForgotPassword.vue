<template>
<div>
    <navbar></navbar>

    <div class="container pt-5 mt-5">
        <div class="row justify-content-center">
            <div class="col-md-4 col-sm-12 card card-body shadow">
                <form @submit.prevent="ForgotPassword">
                    <div class="form-group">
                        <img src="/logo.png" style="max-width: 120px;" class="d-block m-auto" alt="">
                        <h2 class="font-weight-bold text-center text-muted my-4">¡FORGOT PASSWORD!</h2>
                    </div>

                    <b-alert v-if="email_sent" class="text-center my-4" variant="primary" show dismissible>
                        Password Reset Email Sent Succesffully.
                    </b-alert>

                    <div class="form-group">
                        <label class="font-weight-bold text-muted" for="email"><i class="fas fa-envelope-open-text"></i>&nbsp;Email</label>
                        <input type="email" v-model="user.email" :class="{ 'is-invalid': validation.hasError('user.email')}" class="form-control" placeholder="user@movietime.com">
                        <div class="text-danger font-weight-bold">{{ validation.firstError('user.email') }}</div>
                    </div>

                    <div class="form-group my-4">
                        <input type="submit" class="btn btn-block btn-primary" :value="email_sent ? 'RESEND EMAIL' : 'SEND'">
                    </div>

                    <div class="form-group my-4">
                        <router-link to="login" tag="button" class="btn btn-block btn-secondary">
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
import SimpleVueValidation from 'simple-vue-validator';
const Validator = SimpleVueValidation.Validator;
Vue.use(SimpleVueValidation);

export default {
    data: function () {
        return {
            user: {
                email: null,
            },
            email_sent: false,
        };
    },

    validators: {
        'user.email': function (value) {
            return Validator.value(value)
                .required('The email field is required.')
                .minLength(3, 'The email must be at least length 3.')
                .maxLength(255, 'The email must not be over 250 characters.')
                .email('Please type a correct email.');
        },
    },

    methods: {
        async ForgotPassword() {
            var validation = await this.$validate();

            if(validation) {
                var formData = new FormData();
                formData.append('email', this.user.email);

                axios.post('/api/v1/auth/forgot-password', formData)
                    .then((res) => {
                        Vue.swal({
                            icon: 'success',
                            title: '¡Great!',
                            text: 'Password Reset Email Sent Succesffully.',
                            showConfirmButton: false,
                            timer: 1500,
                            timerProgressBar: true,
                        });
                        this.email_sent = true;
                    })
                    .catch(function (error) {
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
}
</script>
