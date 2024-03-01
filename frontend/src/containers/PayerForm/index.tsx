import { useCallback, useEffect } from "react";
import { Grid, Typography } from "@mui/material";
import { InputField } from "../../components/InputField";
import { usePaymentStore } from "../../store";
import { SelectField } from "../../components/SelectField";
import PayerService from "../../services/Payer/payer.service";
import { Option } from "../../store/usePayment/types";
import React from "react"

export const PayerForm = () => {
  const { paymentData, updateField } = usePaymentStore();

  const fetchIdentificationTypes = useCallback(async () => {
    const identificationTypes = await PayerService.getIdentificationTypes();
    updateField("identificationTypes", identificationTypes || []);
  }, [updateField]);

  const normalizeIdentificationTypes = (): Option[] => {
    if (!paymentData.identificationTypes) {
      return [];
    }

    return paymentData.identificationTypes.map((type) => ({
      label: type.name,
      value: type.id,
    }));
  };

  useEffect(() => {
    fetchIdentificationTypes();
  }, [fetchIdentificationTypes]);

  const getInputIdentificationTypeLength = () => {
    const identificationTypes = paymentData.identificationTypes;
    const selectedType = paymentData.payer.identification.type;

    if (!identificationTypes || !selectedType) {
      return undefined;
    }
    const selectedTypeData = identificationTypes.find(
      (type) => type.id === selectedType
    );

    return selectedTypeData
      ? {
          min_length: selectedTypeData.min_length,
          max_length: selectedTypeData.max_length,
        }
      : undefined;
  };

  return (
    <Grid item xs={4} sx={{ display: 'flex', flexDirection: 'column' }}>
      <Typography variant="h5" sx={{width: 400}}>🖋 Dados do Pagador</Typography>
      <InputField
        label="E-mail do Pagador"
        type="email"
        value={paymentData.payer.email}
        onChange={(e) => updateField("payer.email", e.target.value)}
      />
      <SelectField
        label="Tipo de identificação"
        options={normalizeIdentificationTypes()}
        value={paymentData.payer.identification.type}
        onChange={(e) => {
          updateField("payer.identification.number", "");
          updateField("payer.identification.type", e.target.value);
        }}
        
      />
      {paymentData.payer.identification.type && (
        <InputField
          type="string"
          value={paymentData.payer.identification.number}
          label="Número do identificador"
          maxLength={getInputIdentificationTypeLength()?.max_length}
          minLength={getInputIdentificationTypeLength()?.min_length}
          onChange={(e) =>
            updateField("payer.identification.number", e.target.value)
          }
        />
      )}
    </Grid>
  );
};
