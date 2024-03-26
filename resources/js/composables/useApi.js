import {defaultStore} from "../store.js";
import axios from "axios";

export function useApi() {
    const store = defaultStore();

    const getStages = () => {
        axios.get('api/deals/stages',{
            headers: {
                'Content-Type': 'application/json',
            }
        })
            .then(res => {
                store.stages = res.data;
            })
            .catch(error => {
                console.log(error);
            });
    }

    const getAccounts = () => {
        axios.get('api/deals/accounts',{
            headers: {
                'Content-Type': 'application/json',
            }
        })
            .then(res => {
                store.accounts = res.data;
            })
            .catch(error => {
                console.log(error);
            });
    }

    const getOwner = () => {
        axios.get('api/deals/owner-id',{
            headers: {
                'Content-Type': 'application/json',
            }
        })
            .then(res => {
                store.ownerId = res.data;
            })
            .catch(error => {
                console.log(error);
            });
    }

    return {
        getOwner,
        getStages,
        getAccounts,
    }
}
