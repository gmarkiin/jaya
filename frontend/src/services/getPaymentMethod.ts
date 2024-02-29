import { initMercadoPago, getPaymentMethods } from '@mercadopago/sdk-react';
initMercadoPago('TEST-61dad7ab-6ade-4c83-8f3a-4a0402c57d6a');

export async function fetchPaymentMethodsOptions(): Promise<string[]> {
    // const amount = document.getElementById('card-number-id') as HTMLInputElement
    // amount?.addEventListener('amount', function (event) {
    //     const target = event.target as HTMLInputElement;
    //     console.log(target.value);
    //   });
    // console.log(amount)
    const installmentsOptions: string[] = []; // Preciso que isso guarde 2 valores - Installment e InstallmentMessage
    const paymentMethods = await getPaymentMethods({
        bin: "41111111",
    });

    console.log(paymentMethods?.results[0].id)

    return installmentsOptions
}