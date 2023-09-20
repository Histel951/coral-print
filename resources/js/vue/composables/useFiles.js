import {ref} from "vue";
import axios from "axios";

const files = ref([]);

const setFiles = () => {
    files.value = JSON.parse(sessionStorage.getItem('files')) ?? [];
};

const saveFiles = async (uploadedFiles, type = 'designs') => {
    for (let i = 0; i < uploadedFiles.length; i++) {
        const formData = new FormData();
        formData.append("file[0]", uploadedFiles[i]);

        if (type === 'designs') {
            await axios.post('/upload_files?type=temp-designs', formData, {
                headers: {
                    "Content-Type": uploadedFiles[i].type,
                }
            })
                .then((response) => {
                    files.value.push({
                        id: response.data.file_id[0],
                        file_name: uploadedFiles[i].name
                    });

                    sessionStorage.setItem('files', JSON.stringify(files.value));
                })
                .catch((err) => {
                    console.error(err);
                });
        } else if (type === 'requisites') {
            await axios.post('/upload_files?type=requisites', formData, {
                headers: {
                    "Content-Type": uploadedFiles[i].type,
                }
            })
                .then((response) => {
                    files.value.push({
                        id: response.data.file_id[0],
                        file_name: uploadedFiles[i].name
                    });
                })
                .catch((err) => {
                    console.error(err);
                });
        }
    }
};

const deleteFile = (id) => {
    files.value = files.value.filter((file) => file.id !== id);

    if (files.value.length === 0) {
        sessionStorage.removeItem('files');
    } else {
        sessionStorage.setItem('files', JSON.stringify(files.value));
    }

    deleteFileRequest(id);
};

const deleteRequisites = (id) => {
    files.value = [];
    deleteFileRequest(id);
}

const deleteFileRequest = (id) => {
    axios
        .delete('/delete-file/' + id)
        .catch((err) => {
            console.error(err);
        });
};

export default () => {

    return {
        files,
        setFiles,
        saveFiles,
        deleteFile,
        deleteRequisites,
        deleteFileRequest
    }
}
