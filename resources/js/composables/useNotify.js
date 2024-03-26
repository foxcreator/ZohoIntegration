import {toast} from "vue3-toastify";
import "vue3-toastify/dist/index.css";

export function useNotify() {
    const successNotify = (message) => {
        toast(message, {
            theme: "colored",
            type: "success",
            autoClose: 1000
        })
    }

    const errorNotify = (message) => {
        toast(message, {
            theme: "colored",
            type: "error",
            autoClose: 1000
        })
    }

    return {
        successNotify,
        errorNotify,
    }
}
