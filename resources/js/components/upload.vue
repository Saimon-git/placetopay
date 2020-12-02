<script>
    import UploadToS3 from "../common/upload-s3";

    import Mixins from "../mixins";

    export default {
        mixins: [Mixins],

        props: ['title', 'id_name'],

        data() {
            return {
                file: {},
                uploading: false
            }
        },

        computed: {
            current_id() {
                return this.id_name ? this.id_name : 'dlgNewFile';
            },
            uploadProgress() {
                return this.$store.state.uploadProgress;
            },
            uploadStatus() {
                return this.$store.state.uploadStatus;
            }
        },

        methods: {
            async upload (event) {
                this.uploading = true;

                UploadToS3(this.$apollo, event.target.files[0])
                    .then(promises => {
                        this.file = promises[1].file_name;
                        this.$emit('uploaded', this.file);
                        this.toggleModal(this.current_id);
                        this.uploading = false;
                    });
            }
        }
    }
</script>
<template>
  <modal
    :id="current_id"
    :title="title"
    size="md:max-w-xl"
  >
    <form class="flex w-full mb-4 mt-4">
      <div
        v-if="uploading"
        class="w-full"
      >
        <loading
          :loading="true"
          :center="true"
          :color="'#8BC63E'"
        />
        <div class="my-4 mx-auto w-full text-center">
          {{ uploadStatus }}
        </div>
        <div class="shadow w-full bg-grey-light mt-4">
          <div
            class="bg-green text-xs leading-none py-1 text-center text-white"
            :style="'width:'+uploadProgress+'%'"
          >
            {{ uploadProgress }}%
          </div>
        </div>
      </div>

      <div v-else>
        <input
          type="file"
          class="rounded w-full text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
          @change="upload"
        >
      </div>
    </form>
  </modal>
</template>