<?php 

    namespace Util;

    use InvalidArgumentException;
    use JsonException;

    class JsonUtil {


        public function processarArrayParaRetornar($retorno){

            $dados = [];
            $dados[ConstantesGenericasUtil::TIPO] = ConstantesGenericasUtil::TIPO_ERRO;

            if((is_array($retorno) && count($retorno) > 0) || strlen($retorno) > 10){
                $dados[ConstantesGenericasUtil::TIPO] = ConstantesGenericasUtil::TIPO_SUCESSO;
                $dados[ConstantesGenericasUtil::RESPOSTA] = $retorno;
            }

            $this->retornatJson($dados);
        }

        private function retornatJson($json) {
            header('Content-Type: application/json');
            header('Cacha-Control: no-cache, no-store, must-revalidate');
            header('Access-Control-Allow-Methods: GET,POST,PUT, DELETE');
            echo json_encode($json);
            exit;
        }


        /**
         *  @return array|mixed
         */

        public static function tratarCorpoRequisicaoJson(){
        try {
                $postJson = json_decode(file_get_contents('php://input'), true);
        }catch(\JsonException $exception){
                throw new InvalidArgumentException(ConstantesGenericasUtil::MSG_ERR0_JSON_VAZIO);
            }


            if (is_array($postJson) && count($postJson) > 0){
                return $postJson;
            }

        }
    }

?>