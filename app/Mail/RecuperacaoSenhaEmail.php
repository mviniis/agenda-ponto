<?php

namespace App\Mail;

use \Illuminate\Bus\Queueable;
use \Illuminate\Mail\Mailable;
use \Illuminate\Queue\SerializesModels;
use \Illuminate\Mail\Mailables\{Content, Address, Envelope};

/**
 * class RecuperacaoSenha
 * 
 * Classe responsável por realizar a configuração de envio de e-mail de recuperação de senha
 * 
 * @author Matheus Vinicius
 */
class RecuperacaoSenhaEmail extends Mailable {
	use Queueable, SerializesModels;

	private $dadosPessoa = [];

	/**
	 * Construtor da classe
	 * @return void
	 */
	public function __construct($dadosPessoa) {
		$this->dadosPessoa = $dadosPessoa;
	}

	/**
	 * Get the message envelope.
	 *
	 * @return \Illuminate\Mail\Mailables\Envelope
	 */
	public function envelope() {
		return new Envelope(
			from: new Address($_ENV['MAIL_FROM_ADDRESS'], $_ENV['MAIL_FROM_NAME']),
			subject: 'Recuperacao Senha',
		);
	}

	/**
	 * Get the message content definition.
	 *
	 * @return \Illuminate\Mail\Mailables\Content
	 */
	public function content() {
		return new Content(
			view: 'email.recuperacao-senha',
			with: $this->dadosPessoa
		);
	}

	/**
	 * Get the attachments for the message.
	 *
	 * @return array
	 */
	public function attachments() {
		return [];
	}
}
