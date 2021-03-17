<template>
<div>
    <navbar :user="user"></navbar>

    <div class="container pt-5 mt-5" v-if="users.data.length > 0">
        <div class="row">
            <div class="col-md-12">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h3 class="text-primary font-weight-bold m-0 p-0">
                            ALL USERS IN MOVIE TIME
                        </h3>
                        <span class="text-secondary font-weight-bold p-0 m-0">{{ users.from }}-{{ users.to }} of {{ users.total }} users</span>
                    </div>

                    <pagination :limit="-1" show-disabled :data="users" @pagination-change-page="GetUsers">
                        <span slot="prev-nav"><i class="fas fa-angle-left"></i> Prev</span>
                        <span slot="next-nav"><i class="fas fa-angle-right"></i> Next</span>
                    </pagination>
                </div>
            </div>
        </div>

        <div class="row justify-content-center mt-4">
            <div class="col-md-12">
                <table class="table table-striped">
                    <thead class="thead-dark">
                        <tr>
                            <th scope="col">Name</th>
                            <th scope="col">Email</th>
                            <th scope="col">Rol</th>
                            <th scope="col">Options</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="(item, index) in users.data" :key="index">
                            <th scope="row">{{ item.name }}</th>
                            <td>{{ item.email }}</td>
                            <td>
                                <span :class="item.is_admin ? 'badge badge-primary' : 'badge badge-secondary'">
                                    {{ item.is_admin ? 'ADMIN' : 'USER' }}
                                </span>
                            </td>
                            <td>
                                <b-button @click="UpdateUserRol(item)" :variant="!item.is_admin ? 'warning' : 'secondary'">
                                    <span v-if="item.is_admin" v-b-tooltip.hover title="Add Admin Permission">
                                        <i class="fas fa-user-shield"></i>
                                    </span>
                                    <span v-else v-b-tooltip.hover title="Remove Admin Permission">
                                        <i class="fas fa-user-times"></i>
                                    </span>
                                </b-button>
                                <b-button @click="DeleteUser(item)" variant="danger">
                                    <span v-b-tooltip.hover title="Delete User">
                                        <i class="far fa-trash-alt"></i>
                                    </span>
                                </b-button>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="container" v-else>
        <div class="row vh-100 justify-content-center align-items-center">
            <div class="col-md-4 col-sm-12 text-center">
                <i class="fas fa-exclamation-triangle d-block text-primary" style="font-size: 4rem"></i>
                <br />
                <h4>
                    UPS!<br />
                    <small>No user found.</small>
                </h4>
            </div>
        </div>
    </div>
</div>
</template>

<script>
import Pagination from "laravel-vue-pagination";
    export default {
        components: {
            'pagination': Pagination,
        },

        data: function () {
            return {
                user: null,
                users: {
                    data: []
                },
            };
        },

        created() {
            this.user = JSON.parse(localStorage.getItem('mt_user'));
            this.GetUsers();
        },

        methods: {
            GetUsers(page = 1) {
                var token = localStorage.getItem('mt_token');

                const config = {
                    headers: { Authorization: `Bearer ${token}` }
                };

                axios.get('/api/v1/admin/users?page=' + page, null, config)
                    .then((res) => {
                        this.users = res.data;
                    })
                    .catch(function (error) {
                        console.log(error);
                        Vue.swal({
                            toast: true,
                            icon: 'error',
                            title: '¡Ups!',
                            text: 'Users not loaded',
                            position: 'bottom-end',
                            showConfirmButton: false,
                            timer: 3000,
                            timerProgressBar: true,
                        });
                    });
            },

            UpdateUserRol(user) {
                var token = localStorage.getItem('mt_token');

                const config = {
                    headers: { Authorization: `Bearer ${token}` }
                };

                axios.put('/api/v1/admin/users/' + user.id, null, config)
                    .then((res) => {
                        this.GetUsers();
                        Vue.swal({
                            toast: true,
                            icon: 'success',
                            title: '¡Great!',
                            text: 'User updated successfully.',
                            position: 'bottom-end',
                            showConfirmButton: false,
                            timer: 3000,
                            timerProgressBar: true,
                        });
                    })
                    .catch(function (error) {
                        console.log(error);
                        Vue.swal({
                            toast: true,
                            icon: 'error',
                            title: '¡Ups!',
                            text: 'Error updating user.',
                            position: 'bottom-end',
                            showConfirmButton: false,
                            timer: 3000,
                            timerProgressBar: true,
                        });
                    });
            },

            DeleteUser(user) {
                var token = localStorage.getItem('mt_token');

                const config = {
                    headers: { Authorization: `Bearer ${token}` }
                };

                axios.delete('/api/v1/admin/users/' + user.id, null, config)
                    .then((res) => {
                        this.GetUsers();
                        Vue.swal({
                            toast: true,
                            icon: 'success',
                            title: '¡Great!',
                            text: 'User deleted successfully.',
                            position: 'bottom-end',
                            showConfirmButton: false,
                            timer: 3000,
                            timerProgressBar: true,
                        });
                    })
                    .catch(function (error) {
                        console.log(error);
                        Vue.swal({
                            toast: true,
                            icon: 'error',
                            title: '¡Ups!',
                            text: 'Error updating user.',
                            position: 'bottom-end',
                            showConfirmButton: false,
                            timer: 3000,
                            timerProgressBar: true,
                        });
                    });
            },
        }
    }

</script>
