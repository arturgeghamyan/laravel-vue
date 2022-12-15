<template>
  <!-- <loader v-if="loader"></loader> -->

  <breeze-authenticated-layout>
    <template #header>
      <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        Shared tickets
      </h2>
    </template>

    <div class="py-12">
      <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
          <div class="p-6 bg-white border-b border-gray-200">
            <div class="overflow-x-auto relative" v-if="tickets[0]">
              <table
                class="
                  w-full
                  text-sm text-left text-gray-500
                  dark:text-gray-400
                "
              >
                <thead
                  class="
                    text-xs text-gray-700
                    uppercase
                    bg-gray-50
                    dark:bg-gray-700 dark:text-gray-400
                  "
                >
                  <tr>
                    <th scope="col" class="py-3 px-6">Ticket name</th>
                    <th scope="col" class="py-3 px-6">User name</th>
                    <th scope="col" class="py-3 px-6">Actions</th>
                  </tr>
                </thead>
                <tbody>
                  <tr
                    v-for="ticket in tickets"
                    :key="ticket.id"
                    class="
                      bg-white
                      border-b
                      dark:bg-gray-800 dark:border-gray-700
                    "
                  >
                    <th
                      scope="row"
                      class="
                        py-4
                        px-6
                        font-medium
                        text-gray-900
                        whitespace-nowrap
                        dark:text-white
                      "
                    >
                      {{ ticket.ticket.name }}
                    </th>
                    <td class="py-4 px-6">{{ ticket.owner.name }}</td>
                    <td class="py-4 px-6">
                      <breeze-button
                        class="ml-4"
                        @click="openModal(ticket.ticket)"
                      >
                        View Ticket
                      </breeze-button>
                    </td>
                  </tr>
                </tbody>
              </table>
            </div>

            <div v-else class="text-center">There are no tickets available.</div>
          </div>
        </div>
      </div>
    </div>
    <div class="overlay" v-if="showModal" @click="showModal = false"></div>
    <Modal :showModal="showModal" v-if="showModal">
      <div v-if="ticket">
        <div>Name {{ ticket.name }}</div>
        <div>body {{ ticket.description }}</div>
      </div>
    </Modal>
  </breeze-authenticated-layout>
</template>

<script>
import BreezeAuthenticatedLayout from "@/Layouts/Authenticated";
// import Loader from "@/Components/Loader";
import BreezeButton from "@/Components/Button";
import Modal from "@/Components/Modal";
import axios from "axios";

export default {
  components: {
    // Loader,
    Modal,
    BreezeButton,
    BreezeAuthenticatedLayout,
  },

  data() {
    return {
      data: [],
      //   loader: true,
      ticket: {},
      showModal: false,
    };
  },

  props: {
    auth: Object,
    tickets: Object,
    errors: Object,
  },

  methods: {
    openModal(ticket) {
      this.showModal = true;
      this.ticket = ticket;
    },
  },
};
</script>
