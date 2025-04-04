export interface ServiceParams {
    url: string;
    body?: object;
    headers?: object;
    requestType?: 'json' | 'multipart';
    onSuccess?: (response: ServiceResponse) => void;
    onError?: (response: ServiceResponse) => void;
    onInfo?: (response: ServiceResponse) => void;
    onWarning?: (response: ServiceResponse) => void;
    onFieldError?: (response: ServiceResponse) => void;
    setFetching?: (fetching: boolean) => void;
    type?: string;
}

export interface ServiceParamsDocuments {
    url: string;
    headers?: object;
    successData?: SuccessData;
    onSuccess?: (response: string) => void;
    onError?: (response: ServiceResponse) => void;
    onInfo?: (response: ServiceResponse) => void;
    onWarning?: (response: ServiceResponse) => void;
    onFieldError?: (response: ServiceResponse) => void;
    setFetching?: (fetching: boolean) => void;
    type?: string;
}

export interface SuccessData {
    nameDocument: string;
    message: string;
}

export interface ServiceResponse {
    data: any;
    status: string;
    title: string;
    message: string;
    http_status: number;
    errors?: object;
}

export interface ServiceEvents {
    onSuccess?: (response: ServiceResponse) => void;
    onError?: (response: ServiceResponse) => void;
    onInfo?: (response: ServiceResponse) => void;
    onWarning?: (response: ServiceResponse) => void;
    onFieldError?: (response: ServiceResponse) => void;
    setFetching?: (fetching: boolean) => void; // revisar
}

export interface ServiceEventsDocuments {
    onSuccess?: (response: string) => void;
    onError?: (response: ServiceResponse) => void;
    onInfo?: (response: ServiceResponse) => void;
    onWarning?: (response: ServiceResponse) => void;
    onFieldError?: (response: ServiceResponse) => void;
    setFetching?: (fetching: boolean) => void; // revisar
}
