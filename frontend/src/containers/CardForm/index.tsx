import { Grid, Typography } from "@mui/material";
import { InputField } from "../../components/InputField";
import { useCardStore, usePaymentStore } from "../../store";
import { SelectField } from "../../components/SelectField";
import { useCallback, useState, useEffect } from "react";
import CardService from "../../services/Card/card.service";
import { get } from "lodash";
import React from "react"

import {
  Issuer,
  PayerCost,
} from "@mercadopago/sdk-react/coreMethods/util/types";

export const CardForm = () => {
  const [selectedInstallment, setSelectedInstallment] = useState<PayerCost>();
  const [installmentsOptions, setInstallmentsOptions] = useState<PayerCost[]>(
    []
  );
  const [issuer, setIssuer] = useState<Issuer>();
  const { paymentData, updateField: updatePaymentData } = usePaymentStore();
  const { cardData, updateField: updateCardData } = useCardStore();

  const canShowInstallments =
    paymentData.transactionAmount > 0 && cardData.cardNumber.length >= 8;
     
  const getInstallments = useCallback(async () => {
    const paymentMethod = await CardService.fetchInstallments({
      amount: String(paymentData.transactionAmount),
      bin: cardData.cardNumber.substring(0, 8),
    });

    if (!paymentMethod || paymentMethod.length === 0) {
      return;
    }

    setIssuer(paymentMethod[0].issuer);
    setInstallmentsOptions(paymentMethod[0].payer_costs);
  }, [cardData.cardNumber, paymentData.transactionAmount]);

  const formatCurrency = (value: number): string => {
    return value.toLocaleString('pt-BR', { style: 'currency', currency: 'BRL' });
  };

  const parseCurrency = (inputValue: string): number => {
    const numericValue = parseFloat(inputValue
      .replace(/\./g, '')
      .replace(',', '.')
      .replace(/[^\d.-]/g, '')
    );

    return isNaN(numericValue) ? 0 : numericValue;
  };





  useEffect(() => {
    const fetchInstallments = async () => {
      if (canShowInstallments) {
        try {
          await getInstallments();
        } catch (error) {
          console.error('Erro ao carregar parcelas:', error);
        }
      }
    };
  
    fetchInstallments();
  }, [canShowInstallments, getInstallments]);
  return (
    <Grid item xs={8} sx={{ display: 'flex', flexDirection: 'column' }}>
      <Typography variant="h5">💳 Dados do Cartão</Typography>
      <InputField
        label="Valor do pagamento"
        type="text" 
        value={formatCurrency(paymentData.transactionAmount)}
        onChange={(e) => {
          const inputValue = e.target.value;
          const numericValue = parseCurrency(inputValue);
          updatePaymentData("transactionAmount", numericValue);
        }}
      />

      <InputField
        label="Número do Cartão"
        type="string"
        value={cardData.cardNumber}
        onChange={(e) => {
          const cardNumberWithoutSpaces = e.target.value.replace(/\s/g, '')
          updateCardData("cardNumber", cardNumberWithoutSpaces)
        }}
      />


      <InputField
        label="Nome do titular"
        type="string"
        value={cardData.cardholderName}
        onChange={(e) => updateCardData("cardholderName", e.target.value)}
      />

      <InputField
        label="Mês Expiração (MM)"
        type="string"
        value={cardData.cardExpirationMonth}
        minLength={2}
        maxLength={2}
        onChange={(e) => updateCardData("cardExpirationMonth", e.target.value)}
      />

      <InputField
        label="Ano Expiração (YYYY)"
        type="string"
        value={cardData.cardExpirationYear}
        minLength={4}
        maxLength={4}
        onChange={(e) => updateCardData("cardExpirationYear", e.target.value)}
      />

      <InputField
        label="Cód. Verificação (CVV)"
        type="number"
        value={cardData.securityCode}
        minLength={3}
        maxLength={4}
        onChange={(e) => updateCardData("securityCode", e.target.value)}
      />

      {canShowInstallments && (
      <Grid container alignItems="center" spacing={2}>
        <Grid item>
          <SelectField
            label="Número de parcelas"
            options={installmentsOptions.map((installment) => ({
              value: String(installment.installments),
              label: String(installment.recommended_message),
            }))}
            value={
              paymentData.installments === 0
                ? ""
                : String(paymentData.installments)
            }
            onChange={(e) => {
              const selectedInstallment = e.target.value;
              updatePaymentData("installments", Number(selectedInstallment));

              const matchedInstallment = installmentsOptions.find(
                (installment) =>
                  installment.installments === Number(selectedInstallment)
              );

              setSelectedInstallment(matchedInstallment);
            }}
          />
        </Grid>
        <Grid item>
          {issuer && (
            <img src={get(issuer, "thumbnail", "")} alt="Bandeira do cartão" width={50} height={50} style={{ marginTop: 8 }} />
          )}
        </Grid>
      </Grid>)}

      {selectedInstallment && canShowInstallments && (
        <span>
          Total:{" "}
          <strong>
            {new Intl.NumberFormat("pt-BR", {
              style: "currency",
              currency: "BRL",
            }).format(selectedInstallment.total_amount)}
          </strong>{" "}
          <small>
            Juros:{" "}
            {new Intl.NumberFormat("pt-BR", {
              style: "percent",
              minimumFractionDigits: 2,
              maximumFractionDigits: 2,
            }).format(selectedInstallment.installment_rate / 100)}
          </small>
        </span>
      )}
    </Grid>
  );
};
