<script setup>

// Other imports...
import {Head, Link, useForm, usePage} from '@inertiajs/vue3';
import TextInput from "@/Components/TextInput.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import InputError from "@/Components/InputError.vue";
import InputLabel from "@/Components/InputLabel.vue";
import {defineEmits, defineProps} from "vue";

const { incomeIn, update } = defineProps(['incomeIn', 'update']);

const form = useForm({
    name: incomeIn ? incomeIn.name : '',
    amount: incomeIn ? incomeIn.amount : '',
    frequency: incomeIn ? incomeIn.frequency : ''
});

//resting the form
const resetForm = () => {
    form.name = '';
    form.amount = '';
    form.frequency = '';
};
const emits = defineEmits(['form-submitted']);

const handleSubmit = async () => {
    try {
        // Check if update.value is true and expense.value.id is available
        if (update && incomeIn.id) {
            // Use PUT method for update
            await form.put(route('income.update', incomeIn.id), {
                onFinish: resetForm,
            });
        } else {
            // Use POST method for store
            await form.post(route('income.store'), {
                onFinish: resetForm,
            });
        }

        emits('form-submitted');
    } catch (error) {
        // Handle error
        console.error(error);
    }
};

</script>

<template>

    <form @submit.prevent="handleSubmit" class="mt-6 space-y-6">
        <section class="flex xl:w-1/2 xl:m-auto flex-col sm:flex-row m-2 justify-center">
            <div class="mr-5">
                <InputLabel for="name" value="Name"/>

                <TextInput
                    id="name"
                    type="text"
                    class="mt-1 block w-full"
                    v-model="form.name"
                    required
                    autofocus
                    autocomplete="name"
                />

                <InputError class="mt-2" :message="form.errors.name"/>
            </div>

            <div class="mr-5">
                <InputLabel for="amount" value="Amount"/>

                <TextInput
                    id="amount"
                    type="text"
                    class="mt-1 block w-full"
                    v-model="form.amount"
                    required
                    autofocus
                    autocomplete="amount"
                />

                <InputError class="mt-2" :message="form.errors.amount"/>
            </div>


            <div class="mr-5">
                <InputLabel for="frequency" value="Frequency"/>

                <select
                    name="frequency"
                    id="frequency"
                    class="mt-1 block w-full"
                    v-model="form.frequency"
                    required
                    autofocus
                    autocomplete="frequency"
                >
                    <option value="weekly">weekly</option>
                    <option value="bi-weekly">bi-weekly</option>
                    <option value="monthly">monthly</option>
                    <option value="yearly">yearly</option>

                </select>

                <InputError class="mt-2" :message="form.errors.frequency"/>
            </div>

            <div class="mt-6 mr-5">
                <div v-if="!update">
                    <PrimaryButton :disabled="form.processing">Save</PrimaryButton>
                    <Transition
                        enter-active-class="transition ease-in-out"
                        enter-from-class="opacity-0"
                        leave-active-class="transition ease-in-out"
                        leave-to-class="opacity-0"
                    >
                        <p v-if="form.recentlySuccessful" class="text-sm text-gray-600 dark:text-gray-400">Saved.</p>
                    </Transition>
                </div>
                <div v-if="update">
                    <PrimaryButton :disabled="form.processing">Update</PrimaryButton>
                    <Transition
                        enter-active-class="transition ease-in-out"
                        enter-from-class="opacity-0"
                        leave-active-class="transition ease-in-out"
                        leave-to-class="opacity-0"
                    >
                        <p v-if="form.recentlySuccessful" class="text-sm text-gray-600 dark:text-gray-400">updated.</p>
                    </Transition>
                </div>


            </div>


        </section>
    </form>

</template>

<style scoped>

</style>

