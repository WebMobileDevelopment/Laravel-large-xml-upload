<template>
<div>
    <div v-if="currentFile" class="progress">
        <div class="progress-bar progress-bar-info progress-bar-striped" role="progressbar" :aria-valuenow="progress" aria-valuemin="0" aria-valuemax="100" :style="{ width: progress + '%' }">
            {{ progress }}%
        </div>
    </div>

    <label class="btn btn-default">
        <input type="file" ref="file" @change="selectFile" :disabled="uploading" />
    </label>

    <button class="btn btn-success" :disabled="!currentFile || uploading" @click="upload">
        Upload
    </button>
</div>
</template>

<script>
import UploadService from "../UploadFilesService";

export default {
    name: "upload-files",
    data() {
        return {
            currentFile: undefined,
            progress: 0,
            uploading: false,
        };
    },
    methods: {
        selectFile() {
            this.currentFile = this.$refs.file.files[0];
        },
        upload() {
            this.progress = 0;
            this.uploading = true;
            UploadService.upload(
                this.currentFile,
                (event) => {
                    this.progress = Math.round((100 * event.loaded) / event.total);
                },
                "/api/xml_upload"
            ).then((response) => {
                this.uploading = false;
                this.progress = 0;
                this.currentFile = undefined;
            });
        },
    },
    mounted() {},
};
</script>
