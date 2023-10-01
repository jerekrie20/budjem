<script setup>

// Other imports...
import {Head, Link, useForm, usePage} from '@inertiajs/vue3';
import { ref,defineProps,defineEmits  } from "vue";
import "vue3-colorpicker/style.css";

import TextInput from "@/Components/TextInput.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import InputError from "@/Components/InputError.vue";
import InputLabel from "@/Components/InputLabel.vue";

import { ColorPicker } from "vue3-colorpicker";

const pureColor = ref(expense ? expense.color : 'red');

const { expense, update } = defineProps(['expense', 'update']);

const form = useForm({
    name: expense ? expense.name : '',
    color: expense ? expense.color : pureColor,
    type: expense ? expense.type : '',
    due_date: expense ? expense.due_date : '',
    frequency: expense ? expense.frequency : '',
    amount: expense ? expense.amount : '',
});

const resetForm = () => {
    form.name = '';
    form.color = pureColor.value; // assuming pureColor is a ref
    form.type = '';
    form.due_date = '';
    form.frequency = '';
    form.amount = '';
};

const emits = defineEmits(['form-submitted']);

//console.log("Update:", update);
//console.log("Expense ID:", expense ? expense.id : 'Expense is undefined');
const handleSubmit = async () => {
    try {
        // Check if update.value is true and expense.value.id is available
        if (update && expense.id) {
            // Use PUT method for update
            await form.put(route('budget.update', expense.id), {
                onFinish: resetForm,
            });
        } else {
            // Use POST method for store
            await form.post(route('budget.create'), {
                onFinish: resetForm,
            });
        }

        emits('form-submitted');
    } catch (error) {
        // Handle error
        console.error(error);
    }
};



import { watch } from 'vue';

watch(pureColor, (newColor) => {
    form.color = newColor;
});


</script>

<template>

    <form
        @submit.prevent="handleSubmit"
        class="mt-6 space-y-6">
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
                <InputLabel for="type" value="Type"/>

                <TextInput
                    id="type"
                    type="text"
                    class="mt-1 block w-full"
                    v-model="form.type"
                    required
                    autofocus
                    autocomplete="type"
                />

                <InputError class="mt-2" :message="form.errors.type"/>
            </div>

            <div class="mr-5">
                <InputLabel for="due_date" value="Due Date"/>

                <TextInput
                    id="due_date"
                    type="date"
                    class="mt-1 block w-full"
                    v-model="form.due_date"
                    required
                    autofocus
                    autocomplete="due_date"
                />

                <InputError class="mt-2" :message="form.errors.due_date"/>
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
                    <option value="monthly">monthly</option>
                    <option value="yearly">yearly</option>

                </select>

                <InputError class="mt-2" :message="form.errors.frequency"/>
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

            <div class="mt-2 mr-5">

                    <InputLabel class="mb-1" for="color" value="Color"/>
                    <color-picker class="block w-full"  v-model:pureColor="pureColor"/>

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
