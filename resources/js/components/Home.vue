<template>

    <div class="container">
        <div class="row justify-content-center mt-5">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center"><b>Employees</b>  <router-link class="btn btn-success" to="/new">New Employee</router-link></div>

                    <div class="card-body" v-if="!error">

                        <table class="table table-striped">
                        <thead>
                            <tr>
                            <th scope="col">#</th>
                            <th scope="col">First</th>
                            <th scope="col">Last</th>
                            <th scope="col"></th>
                            <th scope="col"></th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="(employee,index) in employees" :key="employee.id">
                                <td><img v-bind:src="employee.photo" width="50" height="50"></td>
                                <td>{{employee.name}}</td>
                                <td>{{employee.surname}}</td>
                                <td><router-link class="btn btn-warning" :to="'/edit/'+employee.id"> View & Edit</router-link></td>
                                <td><button class="btn btn-danger" @click="deleteEntry(employee.id,index)">Remove</button></td>
                            </tr>
                        </tbody>
                        </table>


                    </div>

                    <div class="card-body" v-else>
                        No employess in db or db settings are wrong.
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
                employees: [],
                error: 1
            }
        },
        mounted() {
            let self = this;
            axios.get('/api/employee')
                .then(function (res) {
                    self.employees = res.data;
                    if(self.employees.length > 0){
                        self.error= 0;
                    }
                })
                .catch(function (res) {
                    console.log(res);
                });
        },
        methods: {
            deleteEntry(id, index) {
                if (confirm("Do you really want to delete it?")) {
                    var self = this;
                    axios.delete('/api/employee/' + id)
                        .then(function (resp) {
                            self.employees.splice(index, 1);
                        })
                        .catch(function (resp) {
                            alert("Could not delete company");
                        });
                }
            }
        }
    }
</script>
