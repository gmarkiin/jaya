import { initMercadoPago, getPaymentMethods } from '@mercadopago/sdk-react';
initMercadoPago('TEST-61dad7ab-6ade-4c83-8f3a-4a0402c57d6a');

export async function fetchPaymentMethodsOptions(bin: string): Promise<string | null> {
    try {
        const response = await getPaymentMethods({ bin });
        const id = response?.results[0]?.id;
        return id ?? ''
    } catch (error) {
        return null
    }
}