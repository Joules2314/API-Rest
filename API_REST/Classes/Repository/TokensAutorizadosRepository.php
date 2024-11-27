<?php 

    namespace Repository;

    use BD\MySQL;
    use Util\ConstantesGenericasUtil;
    use InvalidArgumentException;

    class TokensAutorizadosRepository {
        private object $MySQL;
        public const TABELA = "tokens_autorizados";

        public function __construct() {
            $this->MySQL = new MySQL();
        }

        /**
         * @param $token
         */
    
        public function validarToken($token) {
            
            $token = str_replace([' ', 'Bearer'], '' , $token);
            
            if ($token) {
                $ConsultaToken = 'SELECT id FROM ' .self::TABELA . ' WHERE token = :token AND status = :status';
                $stat = $this->getMySQL()->getDb()->prepare($ConsultaToken);
                $stat->bindValue(':token', $token);
                $stat->bindValue(':status', ConstantesGenericasUtil::SIM);
                $stat->execute();
                if ($stat->rowCount() !== 1) {
                    header('HTTP/1.1 401 Unauthorized');
                    throw new InvalidArgumentException(ConstantesGenericasUtil::MSG_ERRO_TOKEN_NAO_AUTORIZADO);
                }
            }else {
                throw new InvalidArgumentException(ConstantesGenericasUtil::MSG_ERRO_TOKEN_VAZIO);
            }

        }

        public function getMySQL() {
            return $this-> MySQL;
        }
    }

?>