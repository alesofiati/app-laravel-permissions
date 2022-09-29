<script setup>
import BreezeAuthenticatedLayout from '@/Layouts/Authenticated.vue';
import Alert  from '@/Components/Alert.vue';
import Swal from 'sweetalert2';
import { Head, Link } from '@inertiajs/inertia-vue3';
import {useForm} from "@inertiajs/inertia-vue3";
import Trash from "@/Icons/Trash.vue";
import Pencil from "@/Icons/Pencil.vue";
import Pagination from "@/Components/Pagination.vue";

const props = defineProps({
    roles: Array,
});

const removeRole = (role_id) => {
    Swal.fire({
        title: 'Deseja remover este perfil?',
        text: "Está ação é irreversivel",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Sim, Remover!'
    }).then((result) => {
        if (result.isConfirmed) {
            useForm().delete(route('role.destroy',role_id))
        }
    })
}


</script>

<template>
    <Head title="Permissões" />

    <BreezeAuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Perfils
            </h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <Alert color="alert-success" :message="$page.props.flash.success" v-if="$page.props.flash.success"/>
                <Alert color="alert-danger" :message="$page.props.flash.error" v-if="$page.props.flash.error"/>

                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mt-3">
                    <Link :href="route('role.create')" class="btn-primary mt-5"> Cadastrar Perfil</Link>
                    <div class="p-6 bg-white border-b border-gray-200">
                        <table>
                            <thead class="text-center">
                                <th scope="col">Perfil</th>
                                <th scope="col" v-if="canAny(['role-edit','role-delete'])">Ações</th>
                            </thead>
                            <tbody>
                                <tr v-for="role in roles.data" :key="role.id"  class="text-center">
                                    <td>{{ role.name }}</td>
                                    <td v-if="canAny(['role-edit','role-delete'])">
                                        <div class="inline-flex space-x-4 content-center">
                                            <Link :href="route('role.edit', role.id)" class="btn-success" v-if="can('role-edit')">
                                                <Pencil/>
                                            </Link>
                                            <button @click="removeRole(role.id)" class="btn-danger" title="Remover perfil" v-if="can('role-delete')">
                                                <Trash/>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                <Pagination :data="roles"/>
            </div>
        </div>
    </BreezeAuthenticatedLayout>
</template>
