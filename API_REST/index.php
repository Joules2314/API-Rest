<?php 

    use Util\RotasUtil;
    use Util\JsonUtil;
    use Validator\RequestValidator;
    use Util\ConstantesGenericasUtil;

    include 'bootstrape.php';

    
    try {
        $RequestValidator = new RequestValidator(RotasUtil::getRotas());
        $retorno = $RequestValidator ->processarRequest();

        $JsonUtil = new JsonUtil();
        $JsonUtil->processarArrayParaRetornar($retorno);


    }catch (Exception $exception) {
        echo json_encode([
            ConstantesGenericasUtil::TIPO => ConstantesGenericasUtil::TIPO_ERRO,
            ConstantesGenericasUtil::RESPOSTA => mb_convert_encoding($exception->getMessage(), 'UTF-8', 'ISO-8859-1')
        ]);
        exit;
    }

?>