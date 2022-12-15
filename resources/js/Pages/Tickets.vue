<template>
  <div>
    <breeze-authenticated-layout>
      <template #header>
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
          Tickets
        </h2>
      </template>

      <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
          <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 bg-white border-b border-gray-200">
              <p v-if="status">{{ status }}</p>
              <div id="app" class="modal-vue">
                <!-- button show -->
                <breeze-button class="ml-4" @click="openModal('create')">
                  Create Tickets
                </breeze-button>

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
                        <th scope="col" class="py-3 px-6">Created</th>
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
                          {{ ticket.name }}
                        </th>
                        <td class="py-4 px-6">{{ ticket.created_at }}</td>
                        <td class="py-4 px-6">
                          <breeze-button
                            class="ml-4"
                            @click="openModal('update', ticket)"
                          >
                            Update Ticket
                          </breeze-button>

                          <breeze-button
                            class="ml-4"
                            @click="openModal('delete', ticket)"
                          >
                            Delete Ticket
                          </breeze-button>

                          <breeze-button
                            class="ml-4"
                            @click="openModal('share', ticket)"
                          >
                            Share Ticket
                          </breeze-button>

                          <breeze-button
                            class="ml-4"
                            @click="openModal('view', ticket)"
                          >
                            View Ticket
                          </breeze-button>
                        </td>
                      </tr>
                    </tbody>
                  </table>
                </div>
                <div v-else class="text-center">
                  There are no tickets available.
                </div>

                <div
                  class="overlay"
                  v-if="showModal"
                  @click="showModal = false"
                ></div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <Modal :showModal="showModal" v-if="showModal">
        <div v-if="type === 'create' || type === 'update'">
          <form @submit.prevent="submit">
            <div class="border-black">
              <breeze-input
                class="mt-1 block w-full"
                v-model="form.name"
                placeholder="Name"
              />
            </div>

            <div class="mt-4 border-black">
              <breeze-input
                class="mt-1 block w-full"
                v-model="form.description"
                placeholder="Description"
              />
            </div>
            <breeze-button
              class="ml-4 uppercase"
              :class="{ 'opacity-25': form.processing }"
              :disabled="form.processing"
            >
              {{ type }}
            </breeze-button>
          </form>
        </div>

        <div v-if="type === 'share'">
          <form @submit.prevent="share">
            <ul class="flex">
              <li v-for="user in users" :key="user.id" class="flex">
                <input type="checkbox" @input="select(user.id)" />
                <span>{{user.name}}</span>
              </li>
            </ul>
            <breeze-button
              class="ml-4 uppercase"
              :class="{ 'opacity-25': form.processing }"
              :disabled="form.processing"
            >
              {{ type }}
            </breeze-button>
          </form>
        </div>

        <div v-if="type === 'delete'">
          <p>`Do you want to delete ticket {{ ticket.name }}?`</p>
          <breeze-button
            @click="deleteTicket(ticket.id)"
            class="ml-4 uppercase"
            :class="{ 'opacity-25': form.processing }"
            :disabled="form.processing"
          >
            {{ type }}
          </breeze-button>
        </div>

        <div v-if="type === 'view' && ticket[0]">
          <div>Name {{ ticket[0].name }}</div>
          <div>body {{ ticket[0].description }}</div>
          <div>Created {{ ticket[0].created_at }}</div>
          <div>
            users
            <p v-for="user in ticket[0].users" :key="user.id">
              {{ user.name }}
            </p>
          </div>
        </div>
      </Modal>
    </breeze-authenticated-layout>
  </div>
</template>

<script>
import BreezeAuthenticatedLayout from "@/Layouts/Authenticated";
import BreezeButton from "@/Components/Button";
import BreezeInput from "@/Components/Input";
import Modal from "@/Components/Modal";

export default {
  components: {
    BreezeAuthenticatedLayout,
    BreezeButton,
    BreezeInput,
    Modal,
  },

  data() {
    return {
      selectedUsers: [],
      showModal: false,
      form: this.$inertia.form({
        id: null,
        name: "",
        description: "",
      }),
      tickets: [],
      ticket: [],
      type: "",
    };
  },

  props: {
    users: Object,
    auth: Object,
    errors: Object,
    status: String,
  },

  mounted() {
    this.getTickets();
  },

  methods: {
    submit() {
      if (this.type === "create") {
        this.form.post(this.route("ticketCreate"), {
          onFinish: () => {
            this.showModal = false;
            this.form.reset();
            this.getTickets();
          },
        });
      } else {
        this.form.put(this.route("ticketUpdate"), {
          onFinish: () => {
            this.showModal = false;
            this.form.reset();
            this.getTickets();
          },
        });
      }
    },

    share() {
      axios
        .post(this.route("ticketShare"), {
          data: { userIds: this.selectedUsers, ticketId: this.ticket.id },
        })
        .then(() => {
          this.getTickets();
          this.showModal = false;
        });
    },

    getTickets() {
      axios.get(this.route("getTickets")).then((r) => {
        this.tickets = r.data;
      });
    },

    openModal(type, ticket = {}) {
      this.showModal = true;
      this.type = type;
      this.ticket = ticket;
      this.form.name = "";
      this.form.description = "";

      if (type === "update") {
        this.form.id = ticket.id;
        this.form.name = ticket.name;
        this.form.description = ticket.description;
      }

      if (type === "view") {
        const id = ticket.id;
        axios.get(this.route("getTicket"), { params: { id } }).then((r) => {
          this.ticket = r.data;
        });
      }
    },

    deleteTicket(id) {
      axios.delete(this.route("ticketDelete"), { data: { id } }).then(() => {
        this.getTickets();
        this.showModal = false;
      });
    },

    select(id) {
      if (this.selectedUsers.includes(id)) {
        this.selectedUsers = _.without(this.selectedUsers, id);
      } else {
        this.selectedUsers.push(id);
      }
    },
  },
};
</script>


