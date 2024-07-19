<template>
<div class="container mt-4">
    <button type="button" id="create_modal_button" class="btn btn-success mb-2" data-bs-toggle="modal" data-bs-target="#createModal">Create</button>
    <table class="table table-bordered">
        <thead>
            <tr class="bg-light">
                <th scope="col">Name</th>
                <th scope="col">Description</th>
                <th scope="col">Price</th>
                <th scope="col">Action</th>
            </tr>
        </thead>
        <tbody>
            <template v-if="products.length > 0">
            <tr v-for="(product, index) in products" :key="index">
                <td>{{ product.name }}</td>
                <td>{{ product.description }}</td>
                <td>{{ product.price }}</td>
                <td>
                    <button type="button" @click="edit(product)" id="update_modal_button" class="btn btn-info mb-2" data-bs-toggle="modal" data-bs-target="#updateModal">Edit</button>
                    <button type="button" @click="deleteData(product.id)" class="btn btn-danger mb-2">Delete</button>
                </td>
            </tr>
            </template>
            <template v-else>
            <tr>
                <td colspan="99">No Data</td>
            </tr>
            </template>
        </tbody>
    </table>

    <!-- Create Modal -->
    <div class="modal fade" id="createModal" tabindex="-1" aria-labelledby="createModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="createModalLabel">Create Product</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form @submit.prevent="create()">
                        <div class="mb-3">
                            <label for="form_name" class="form-label">Name</label>
                            <input type="text" class="form-control" id="form_name" v-model="formCreate.name" required>
                        </div>
                        <div class="mb-3">
                            <label for="form_description" class="form-label">Description</label>
                            <input type="text" class="form-control" id="form_description" v-model="formCreate.description" required>
                        </div>
                        <div class="mb-3">
                            <label for="form_price" class="form-label">Price</label>
                            <input type="number" class="form-control" id="form_price" v-model="formCreate.price" required>
                        </div>
                        <button type="submit" id="create_button" class="btn btn-primary">Submit</button>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Update Modal -->
    <div class="modal fade" id="updateModal" tabindex="-1" aria-labelledby="updateModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="updateModalLabel">Update Product</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form @submit.prevent="update()">
                        <div class="mb-3">
                            <label for="form_name" class="form-label">Name</label>
                            <input type="text" class="form-control" id="form_name" v-model="formUpdate.name" required>
                        </div>
                        <div class="mb-3">
                            <label for="form_description" class="form-label">Description</label>
                            <input type="text" class="form-control" id="form_description" v-model="formUpdate.description" required>
                        </div>
                        <div class="mb-3">
                            <label for="form_price" class="form-label">Price</label>
                            <input type="number" class="form-control" id="form_price" v-model="formUpdate.price" required>
                        </div>
                        <button type="submit" id="update_button" class="btn btn-primary">Submit</button>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
</div>
</template>
    
<script>
import axios from 'axios'
export default {
    data () {
        return {
            products: [],
            formCreate: {
                name:'',
                description:'',
                price:'',
            },
            formUpdate: {
                id:'',
                name:'',
                description:'',
                price:'',
            }
        }
    },

    mounted () {
        this.getData()
    },

    methods: {
        getData(){
            const self = this

            axios.get('http://127.0.0.1:8000/api/v1/product')
            .then(function (response) {
                if(response.status == 200) {
                    self.products = response.data.data
                }else{
                    alert(response.data.message)
                }
            })
        },

        create(){
            const self = this

            let create_button = document.getElementById("create_button")
            create_button.disabled = true

            axios.post('http://127.0.0.1:8000/api/v1/product/create', self.formCreate)
            .then(function (response) {
                create_button.disabled = false
                
                self.formCreate = {
                    name:'',
                    description:'',
                    price:'',
                }

                alert(response.data.message)

                document.getElementById("create_modal_button").click()

                self.getData()
            })
        },

        edit(product){
            const self = this
            self.formUpdate.id = product.id
            self.formUpdate.name = product.name
            self.formUpdate.description = product.description
            self.formUpdate.price = product.price
        },

        update(){
            const self = this

            let update_button = document.getElementById("update_button")
            update_button.disabled = true

            axios.post('http://127.0.0.1:8000/api/v1/product/update', self.formUpdate)
            .then(function (response) {
                update_button.disabled = false
                
                self.formUpdate = {
                    id:'',
                    name:'',
                    description:'',
                    price:'',
                }

                alert(response.data.message)

                document.getElementById("update_modal_button").click()

                self.getData()
            })
        },

        deleteData(id){
            const self = this
            if (confirm("Are You Sure?")) {
                let form_delete = {
                    id: id
                }

                axios.post('http://127.0.0.1:8000/api/v1/product/delete', form_delete)
                .then(function (response) {
                    alert(response.data.message)
                    self.getData()
                })
            }
        },
    }
}
</script>