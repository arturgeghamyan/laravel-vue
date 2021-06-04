<template>
    <breeze-validation-errors class="mb-4" />

    <div v-if="status" class="mb-4 font-medium text-sm text-green-600">
        {{ status }}
    </div>

    <form @submit.prevent="submit">
        <div>
            <breeze-label for="code" value="Code" />
            <breeze-input id="code" name="code" class="mt-1 block w-full" v-model="form.code" required autofocus autocomplete="code"/>
        </div>

        <div class="flex items-center justify-end mt-4">
            <breeze-button class="ml-4" :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                Verify
            </breeze-button>
        </div>
    </form>
</template>

<script>
import BreezeButton from '@/Components/Button'
import BreezeGuestLayout from "@/Layouts/Guest"
import BreezeInput from '@/Components/Input'
import BreezeCheckbox from '@/Components/Checkbox'
import BreezeLabel from '@/Components/Label'
import BreezeValidationErrors from '@/Components/ValidationErrors'

export default {
    layout: BreezeGuestLayout,

    components: {
        BreezeButton,
        BreezeInput,
        BreezeCheckbox,
        BreezeLabel,
        BreezeValidationErrors
    },
    data() {
        return {
            form: this.$inertia.form({
                code: '',
            })
        }
    },
    props: {
        auth: Object,
        canResetPassword: Boolean,
        errors: Object,
        status: String,
    },

    methods: {
        submit() {
            this.form.post(this.route('verify'))
        }
    }
}
</script>
