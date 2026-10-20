```sema
#!/usr/bin/env sema
;; A tiny research agent with a budget.

(deftool lookup
  "Look up a fact about a city."
  {:city {:type :string}}
  (lambda (city)
    (string/append "Facts about " city)))

(defagent guide
  {:system "You are a travel guide."
   :tools [lookup]
   :max-turns 3})

(define (ask city)
  (llm/with-budget {:max-cost-usd 0.05}
    (fn ()
      (let ((answer (agent/run guide f"Tell me about ${city}")))
        (if (string? answer)
            answer
            (throw "no answer"))))))

(define cities '("Oslo" "Bergen" "Tromsø"))
(map #(ask %) cities)
(println (+ 1/2 0.5 #xFF -1.5e3) #t nil #\space)
```
