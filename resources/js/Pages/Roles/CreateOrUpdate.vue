<script setup>
import BreezeAuthenticatedLayout from '@/Layouts/Authenticated.vue';
import {Head, Link, useForm} from '@inertiajs/inertia-vue3';
import BreezeInput from '@/Components/Input.vue';
import BreezeLabel from '@/Components/Label.vue';
import BreezeButton from '@/Components/Button.vue';
import BreezeInputError from '@/Components/InputError.vue';

const props = defineProps({
    role: Object,
    permissions:Array
})

let permissionsCheckeds = []

Object.keys(props.permissions).forEach(group => {
    props.permissions[group].forEach(permission => {
        if(permission.checked){
            permissionsCheckeds[permission.id] = permission.id
        }
    })
});

const form = useForm({
    role: props.role ? props.role.name : '',
    permissions: permissionsCheckeds.length ? permissionsCheckeds :  []
})

const submit = () => {
    if(props.role){
        form.put(route('role.update', props.role.id))
        return
    }
    form.post(route('role.store'));
}

const title = props.role ? "Editar Perfil" : "Cadastrar Perfil"

</script>

<template>
    <Head :title="title" />

    <BreezeAuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Cadastrar Perfil
            </h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 bg-white border-b border-gray-200">
                        <form @submit.prevent="submit">
                            <div>
                                <BreezeLabel for="role" value="Perfil"/>
                                <BreezeInput id="role" type="text" class="mt-1 block w-full" placeholder="Ex: Financeiro" v-model="form.role"/>
                                <BreezeInputError class="mt-2" :message="form.errors.role" />
                            </div>
                            <BreezeInputError class="mt-2" :message="form.errors.permissions" />
                            <div class="mt-2 inline-flex grid-cols-3 gap-5">
                                <div v-for="(group, index) in permissions" :key="group">
                                    <p class="capitalize font-bold">{{ index }}</p>
                                    <label v-for="{id, description} in group" class="inline-flex items-center w-full mt-2" :for="id">
                                        <input type="checkbox" :id="id" class="form-checkbox border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm" v-model.lazy="form.permissions" v-bind:value="id">
                                        <span class="ml-2 capitalize">{{ description }}</span>
                                    </label>
                                </div>
                            </div>
                            <div class="flex items-center justify-end mt-4">
                                <BreezeButton class="ml-4" :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                                    Salvar
                                </BreezeButton>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </BreezeAuthenticatedLayout>
</template>
