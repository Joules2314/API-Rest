<?php 

    namespace Service;

    use Repository\UsuariosRepository;
    use Util\ConstantesGenericasUtil;
    use InvalidArgumentException;

    class UsuariosService {

        public const TABELA = "usuarios";
        public const RECURSOS_GET = ['Listar'];
        public const RECURSOS_DELETE = ['deletar'];
        public const RECURSOS_POST = ['cadastrar'];
        public const RECURSOS_PUT = ['atualizar'];


        private array $dados;
        private array $dadosCorpoRequest = [];

        private object $UsuariosRepository;

        public function __construct($dados = []) {
           $this->dados = $dados; 
           $this->UsuariosRepository = new UsuariosRepository();
        }

        public function validarGet() {
            $retorno = null;
            $recurso = $this->dados['recurso'];
            if(in_array($recurso, self::RECURSOS_GET, true)) {
                $retorno = $this->dados['id'] > 0 ? $this->getOneByKey() : $this->$recurso();
            }else {
                throw new InvalidArgumentException(ConstantesGenericasUtil::MSG_ERRO_RECURSO_INEXISTENTE);
            }
            

            if ($retorno === null){
                throw new InvalidArgumentException(ConstantesGenericasUtil::MSG_ERRO_GENERICO);
            }

            return $retorno;
        }


        public function setDadosCorpoRequest($dadosRequest){
            $this->dadosCorpoRequest = $dadosRequest;
        }

        public function validarDelete() {
            $retorno = null;
            $recurso = $this->dados['recurso'];
            if(in_array($recurso, self::RECURSOS_DELETE, true)) {
                if($this->dados['id'] > 0){
                    $retorno = $this->$recurso();
                }else {
                    throw new InvalidArgumentException(ConstantesGenericasUtil::MSG_ERRO_ID_OBRIGATORIO);
                }
            }else {
                throw new InvalidArgumentException(ConstantesGenericasUtil::MSG_ERRO_RECURSO_INEXISTENTE);
            }
            

            if ($retorno === null){
                throw new InvalidArgumentException(ConstantesGenericasUtil::MSG_ERRO_GENERICO);
            }

            return $retorno;
        }


        public function validarPost() {
            $retorno = null;
            $recurso = $this->dados['recurso'];
            if(in_array($recurso, self::RECURSOS_POST, true)) {
                $retorno = $this->$recurso();
            }else {
                throw new InvalidArgumentException(ConstantesGenericasUtil::MSG_ERRO_RECURSO_INEXISTENTE);
            }
            

            if ($retorno === null){
                throw new InvalidArgumentException(ConstantesGenericasUtil::MSG_ERRO_GENERICO);
            }

            return $retorno;
        }

        public function validarPut() {
            $retorno = null;
            $recurso = $this->dados['recurso'];
            if(in_array($recurso, self::RECURSOS_PUT, true)) {
                if($this->dados['id'] > 0){
                    $retorno = $this->$recurso();
                }else {
                    throw new InvalidArgumentException(ConstantesGenericasUtil::MSG_ERRO_ID_OBRIGATORIO);
                }
            }else {
                throw new InvalidArgumentException(ConstantesGenericasUtil::MSG_ERRO_RECURSO_INEXISTENTE);
            }
            

            if ($retorno === null){
                throw new InvalidArgumentException(ConstantesGenericasUtil::MSG_ERRO_GENERICO);
            }

            return $retorno;
        }

        private function getOneByKey() {
            return $this->UsuariosRepository->getMySQL()->getOneByKey(self::TABELA, $this->dados['id']);
        }


        private function Listar() {
            return $this->UsuariosRepository->getMySQL()->getAll(self::TABELA);
        }

        private function deletar() {
            return $this->UsuariosRepository->getMySQL()->delete(self::TABELA, $this->dados['id']);
        }

        private function cadastrar() {

            [$login, $senha] = [$this->dadosCorpoRequest['login'], $this->dadosCorpoRequest['senha']];

            if ($login && $senha){
                if($this->UsuariosRepository->insertUser($login,$senha)> 0){
                    $idInserido = $this->UsuariosRepository->getMySQL()->getDb()->lastInsertId();
                    $this->UsuariosRepository->getMySQL()->getDb()->commit();
                    return ['id_inserido' => $idInserido];
                }

                $this->UsuariosRepository->getMySQL()->getDb()->rollBack();

                throw new InvalidArgumentException(ConstantesGenericasUtil::MSG_ERRO_GENERICO);
            }
            throw new InvalidArgumentException(ConstantesGenericasUtil::MSG_ERRO_LOGIN_SENHA_OBRIGATORIO);
        }


        private function atualizar() {
            if ($this->UsuariosRepository->updateUser($this->dados['id'], $this->dadosCorpoRequest) > 0) {
                $this->UsuariosRepository->getMySQL()->getDb()->commit();
                return ConstantesGenericasUtil::MSG_ATUALIZADO_SUCESSO;
            }

            $this->UsuariosRepository->getMySQL()->getDb()->rollBack();
            throw new InvalidArgumentException(ConstantesGenericasUtil::MSG_ERRO_NAO_AFETADO);
        }
    }

?>