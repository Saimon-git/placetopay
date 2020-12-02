<script>
import AsideMenu from "./aside-menu";

export default {
  name: "MenuComponent",

  components: { AsideMenu },

  props: [
    "super_admin",
    "email_help",
    "app_name",
    "app_logo",
    "app_logo_compacted",
    "app_role"
  ],

  data() {
    return {
      isToogle: false
    };
  },

  computed: {
    email_url() {
      return `mailto:${this.email_help}`;
    }
  },

  methods: {
    toogle() {
      if (!this.isToogle) {
        this.isToogle = true;
        let element = document.getElementById("content-ppal");
        element.classList.add("m-1/12");
        element.classList.remove("m-1/5");
      } else {
        this.isToogle = false;
        let element = document.getElementById("content-ppal");
        element.classList.add("m-1/5");
        element.classList.remove("m-1/12");
      }
    }
  }
};
</script>

<template>
  <div
    class="shadow z-10 bg-white fixed h-screen rounded-r"
    :class="isToogle ? 'w-1/12 toggle-aside' : 'w-1/5'"
  >
    <div class="flex items-center justify-between">
      <div class="w-full mx-auto mt-4 mb-4">
        <img
          v-if="!isToogle"
          :src="app_logo"
          class="p-4"
        >
        <div
          v-if="isToogle"
          class="w-full flex justify-end p-4"
        >
          <img
            :src="app_logo_compacted"
            class="h-8"
          >
        </div>
      </div>
      <div class="justify-end">
        <a
          href="#"
          @click="toogle"
        >
          <svg
            v-if="!isToogle"
            xmlns="http://www.w3.org/2000/svg"
            viewBox="0 0 24 24"
            width="40"
            height="40"
          >
            <path
              class="heroicon-ui"
              d="M14.7 15.3a1 1 0 0 1-1.4 1.4l-4-4a1 1 0 0 1 0-1.4l4-4a1 1 0 0 1 1.4 1.4L11.42 12l3.3 3.3z"
            />
          </svg>
          <svg
            v-else
            xmlns="http://www.w3.org/2000/svg"
            viewBox="0 0 24 24"
            width="40"
            height="40"
          >
            <path
              class="heroicon-ui"
              d="M9.3 8.7a1 1 0 0 1 1.4-1.4l4 4a1 1 0 0 1 0 1.4l-4 4a1 1 0 0 1-1.4-1.4l3.29-3.3-3.3-3.3z"
            />
          </svg>
        </a>
      </div>
    </div>
    <aside class="flex items-center w-full">
      <div class="py-2 w-full ml-2">
        <aside-menu
          :active="isToogle"
          :super_admin="super_admin"
          :app_role="app_role"
        />
      </div>
    </aside>
    <div
      v-if="!isToogle"
      class="w-full absolute bottom-0 pb-3 ml-5 text-left"
    >
      <p class="text-orange text-base">
        Need Help?
      </p>
      <br>
      <a
        :href="email_url"
        class="cursor-pointer"
      ><label class="mt-1 cursor-pointer">CONTACT {{ app_name }}</label></a>
    </div>
  </div>
</template>