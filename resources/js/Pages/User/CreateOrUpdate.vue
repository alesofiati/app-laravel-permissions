<script setup>
import BreezeAuthenticatedLayout from '@/Layouts/Authenticated.vue';
import {Head, useForm} from '@inertiajs/inertia-vue3';
import BreezeInput from '@/Components/Input.vue';
import BreezeLabel from '@/Components/Label.vue';
import BreezeButton from '@/Components/Button.vue';
import BreezeInputError from '@/Components/InputError.vue';
import Select from '@/Components/Select.vue'

const props = defineProps({
    user:Array,
    roles: Array
})

const form = useForm({
    name: props.user ? props.user.name : '',
    email: props.user ? props.user.email : '',
    role: props.user ? props.user.userRoles : '',
    password:'',
    password_confirmation:''
});

const submit = () => {
    if(props.user){
        form.patch(route('user.update', props.user.id),{
            onFinish: () => form.reset('password','password_confirmation'),
        })
        return
    }
    form.post(route('user.store'),{
        onFinish: () => form.reset('password','password_confirmation'),
    })
}


const title = props.user ? "Editar Usúario" : "Cadastrar Usúario"

</script>
<template>
    <Head :title="title" />

    <BreezeAuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ title }}
            </h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 bg-white border-b border-gray-200">
                        <form @submit.prevent="submit">
                            <div class="grid grid-cols-3 gap-4">
                                <div>
                                    <BreezeLabel for="name" value="Nome"/>
                                    <BreezeInput id="name" type="text" class="mt-1 block w-full" placeholder="Ex: João" v-model="form.name"/>
                                    <BreezeInputError class="mt-2" :message="form.errors.name" />
                                </div>
                                <div>
                                    <BreezeLabel for="email" value="E-mail"/>
                                    <BreezeInput id="email" type="email" class="mt-1 block w-full" placeholder="Ex: joao@applaravel.com" v-model="form.email"/>
                                    <BreezeInputError class="mt-2" :message="form.errors.email" />
                                </div>
                                <div>
                                    <BreezeLabel for="perfil" value="Perfil"/>
                                    <Select id="perfil" class="mt-1 block w-full" v-model="form.role">
                                        <option v-for="role in roles" v-bind:value="role">{{ role }}</option>
                                    </Select>
                                    <BreezeInputError class="mt-2" :message="form.errors.role" />
                                </div>
                            </div>

                            <div class="grid grid-cols-2 gap-4 mt-5">
                                    <div>
                                        <BreezeLabel for="password" value="Senha"/>
                                        <BreezeInput id="password" type="password" class="mt-1 block w-full" v-model="form.password"/>
                                        <BreezeInputError class="mt-2" :message="form.errors.password" />
                                    </div>
                                    <div>
                                        <BreezeLabel for="password_comfirmation" value="Comfirmar Senha"/>
                                        <BreezeInput id="password_comfirmation" type="password" class="mt-1 block w-full" v-model="form.password_confirmation"/>
                                        <BreezeInputError class="mt-2" :message="form.errors.password_confirmation" />
                                    </div>
                            </div>

                            <div class="flex justify-end mt-4">
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
