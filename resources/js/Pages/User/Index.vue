<script setup>
import BreezeAuthenticatedLayout from '@/Layouts/Authenticated.vue';
import { Head,Link } from '@inertiajs/inertia-vue3';
import Pencil from "@/Icons/Pencil.vue";
import Alert  from '@/Components/Alert.vue';
import Pagination from '@/Components/Pagination.vue'

const props = defineProps({
    users: Array
})

</script>

<template>
    <Head title="Usúarios" />

    <BreezeAuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Usúarios
            </h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <Alert color="alert-success" class="rounded-md" :message="$page.props.flash.success" v-if="$page.props.flash.success"/>
                <Alert color="alert-danger" class="rounded-md" :message="$page.props.flash.error" v-if="$page.props.flash.error"/>

                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mt-3">
                    <Link :href="route('user.create')" class="btn-primary mt-5"> Cadastrar Usúario</Link>
                    <div class="p-6 bg-white border-b border-gray-200">
                        <table>
                            <thead class="text-center">
                                <th scope="col">Nome</th>
                                <th scope="col">E-mail</th>
                                <th scope="col">Perfil Acesso</th>
                                <th scope="col">Dt. Cadastro</th>
                                <th scope="col" v-if="can('user-edit')">Ações</th>
                            </thead>
                            <tbody>
                                <tr v-for="user in users.data" :key="user.id" class="text-center">
                                    <td>{{ user.name }}</td>
                                    <td>{{ user.email }}</td>
                                    <td>{{ user.userRoles }}</td>
                                    <td>{{ user.created_at }}</td>
                                    <td v-if="can('user-edit')">
                                        <div class="inline-flex space-x-3 content-center">
                                            <Link :href="route('user.edit', user.id)" class="btn-success">
                                                <Pencil/>
                                            </Link>
                                        </div>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <Pagination :data="users" />
                </div>
            </div>
        </div>
    </BreezeAuthenticatedLayout>
</template>
