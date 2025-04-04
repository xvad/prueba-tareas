import { deleteCookie, getCookie } from "cookies-next";
import { getFormData } from "./ApiHelper";
import { ServiceParams, ServiceResponse } from "./interfaces";




const useFetch = () => {
    const doGet = (serviceParams: ServiceParams) => {
        abstractFetch('GET', serviceParams);
    };

    const doPost = (serviceParams: ServiceParams) => {
        abstractFetch('POST', serviceParams);
    };

    const doPut = (serviceParams: ServiceParams) => {
        abstractFetch('PUT', serviceParams);
    };

    const doDelete = (serviceParams: ServiceParams) => {
        abstractFetch('DELETE', serviceParams);
    };
    const getFetchHeaders = (type: 'json' | 'multipart' = 'json', headers?: object) => {
      let fetchDefaultHeaders: Record<string, string> = {
        'Authorization': `Bearer ${getCookie('token')}`
      }
    
      if (type === 'json') {
        fetchDefaultHeaders['Content-Type'] = 'application/json'
        fetchDefaultHeaders['Accept'] = 'application/json'
      }
      // Nota: NO se debe setear 'Content-Type' manualmente con multipart
      // porque el navegador lo agrega automáticamente con los límites del form
    
      if (headers) {
        fetchDefaultHeaders = { ...fetchDefaultHeaders, ...headers }
      }
    
      return fetchDefaultHeaders
    }
    

    const abstractFetch = (method: string, serviceParams: ServiceParams) => {
        const {
            url,
            body,
            headers,
            requestType = 'json',
            onSuccess,
            onError,
            onInfo,
            onWarning,
            onFieldError,
            setFetching,
            type
        } = serviceParams;

        let httpStatus = 0;

        if (setFetching) {
            setFetching(true);
        }
        let fetchDefaultHeaders = getFetchHeaders(requestType, headers);

        fetch(url, {
            method: method,
            credentials: 'include',
            headers: { ...fetchDefaultHeaders, ...headers },
            body: body ? (requestType == 'json' ? JSON.stringify(body) : getFormData(body)) : null
        })
            .then((response) => {
                httpStatus = response.status;
                return response.json();
            })
            .then((response) => {
                if (
                    httpStatus === 401 &&
                    !window.location.href.includes('/login')
                ) {
                  deleteCookie('token');
                  deleteCookie('rememberMe');
                  window.location.href ='/login';
                }

                response.http_status = httpStatus;
                handleResponse(response, onSuccess, onError, onFieldError);
                if (setFetching) {
                    setFetching(false);
                }
            })
            .catch((e) => {
                // console.log(e);
                if (setFetching) {
                    setFetching(false);
                }
            });
    };

   
    const handleResponse = (
        response: ServiceResponse,
        onSuccess?: (response: ServiceResponse) => void,
        onError?: (response: ServiceResponse) => void,
        onFieldError?: (response: ServiceResponse) => void
    ) => {
        if (response.http_status >= 200 && response.http_status < 300) {
            if (onSuccess) {
                onSuccess(response);
            }
        }else if (response.http_status == 422) {

            if (onFieldError) {
                onFieldError(response);
            }
        }else if (response.http_status >= 400 && response.http_status < 600) {
            if (onError) {
                onError(response);
            }
        }
    };

    return {
        doGet,
        doPost,
        doPut,
        doDelete,
    };
};

export default useFetch;
