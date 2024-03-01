import { getPaymentMethods } from '@mercadopago/sdk-react';
import { PaymentMethodsServiceMethods } from './paymentMethod.types';

const PaymentMethodsService: PaymentMethodsServiceMethods = {
  fetchPaymentMethods: (bin: string) => {
    return getPaymentMethods({ bin });
  },
};

export default PaymentMethodsService;