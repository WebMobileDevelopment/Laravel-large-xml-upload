import http from "./http-common";

class UploadFilesService {


    upload(book_array, onUploadProgress, url = "") {
        // let formData = new FormData();

        // formData.append("import_file", file);

        return window.axios.post(url, {
            params: book_array,
            paramsSerializer: params => {
                return qs.stringify(params)
            },
            onUploadProgress
        });
    }

    // getFiles() {
    //     return http.get("/files");
    // }
}

export default new UploadFilesService();